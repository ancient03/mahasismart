<?php

namespace App\Http\Controllers\toko; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Toko;
use App\Models\User; 
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\JsonResponse;

class RegisterTokoController extends Controller 
{
    /**
     * Menampilkan form registrasi toko.
     */
    public function create(): View|RedirectResponse 
    {
        if (Auth::user()->toko()->exists()) {
            return redirect()->route('profile')->with('error', 'Anda sudah terdaftar memiliki toko.');
        }
        return view('page.profile.register-toko'); 
    }

    /**
     * Validasi OCR KTP/KTM menggunakan OCR.space API
     * Endpoint ini menerima file gambar dan melakukan OCR
     */
    public function validateDocument(Request $request): JsonResponse
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:5120',
                'nik_nim' => 'required|string',
                'nama_lengkap' => 'required|string',
                'jenis_dokumen' => 'required|in:ktp,ktm',
                'email_mahasiswa' => 'nullable|string|email', // Untuk validasi NIM-Email
            ]);

            $image = $request->file('image');
            $nikNim = $request->input('nik_nim');
            $namaLengkap = strtolower($request->input('nama_lengkap'));
            $jenisDokumen = $request->input('jenis_dokumen');
            $emailMahasiswa = $request->input('email_mahasiswa');

            // OCR.space API Call
            $ocrApiKey = env('OCR_KEY');
            
            if (!$ocrApiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konfigurasi sistem belum lengkap',
                    'user_message' => 'Mohon maaf, sistem OCR belum terkonfigurasi. Silakan hubungi administrator.',
                    'type' => 'config_error'
                ], 500);
            }

            // Kirim request ke OCR.space
            $response = Http::timeout(30)->attach(
                'file',
                file_get_contents($image->getRealPath()),
                $image->getClientOriginalName()
            )->post('https://api.ocr.space/parse/image', [
                'apikey' => $ocrApiKey,
                'language' => 'eng',
                'isOverlayRequired' => 'false',  
                'detectOrientation' => 'true',
                'scale' => 'true',
                'OCREngine' => '2',
            ]);

            if (!$response->successful()) {
                \Log::error('OCR API Error', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal terhubung ke layanan OCR',
                    'user_message' => 'Terjadi masalah saat menghubungi server pemrosesan gambar. Silakan coba beberapa saat lagi.',
                    'type' => 'network_error'
                ], 500);
            }

            $ocrResult = $response->json();

            // Check for OCR errors
            if (isset($ocrResult['IsErroredOnProcessing']) && $ocrResult['IsErroredOnProcessing']) {
                $errorMessage = $ocrResult['ErrorMessage'][0] ?? 'Kesalahan pemrosesan gambar';
                
                return response()->json([
                    'success' => false,
                    'message' => 'OCR processing failed',
                    'user_message' => 'Gambar tidak dapat diproses. Pastikan foto jelas, tidak blur, dan pencahayaan cukup.',
                    'type' => 'ocr_error',
                    'details' => $errorMessage
                ], 400);
            }

            if (!isset($ocrResult['ParsedResults'][0]['ParsedText'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat membaca teks dari gambar',
                    'user_message' => 'Tidak dapat mendeteksi teks pada gambar. Pastikan foto KTP/KTM jelas dan tidak tertutup.',
                    'type' => 'no_text_detected'
                ], 400);
            }

            $extractedText = strtolower($ocrResult['ParsedResults'][0]['ParsedText']);
            
            // Check if text is too short
            if (strlen($extractedText) < 20) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teks terlalu sedikit',
                    'user_message' => 'Teks yang terdeteksi terlalu sedikit. Pastikan foto memiliki pencahayaan yang baik dan tidak blur.',
                    'type' => 'insufficient_text',
                    'detected_length' => strlen($extractedText)
                ], 400);
            }

            // Validasi berdasarkan jenis dokumen
            $validation = $this->validateExtractedText(
                $extractedText, 
                $nikNim, 
                $namaLengkap, 
                $jenisDokumen,
                $emailMahasiswa
            );

            return response()->json($validation);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi input gagal',
                'user_message' => 'File yang diupload tidak valid. Pastikan format JPG/PNG/WEBP dan maksimal 5MB.',
                'type' => 'validation_error',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('OCR Validation Error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem',
                'user_message' => 'Maaf, terjadi kesalahan pada sistem. Silakan coba lagi atau hubungi administrator jika masalah berlanjut.',
                'type' => 'system_error'
            ], 500);
        }
    }

    /**
     * Validasi hasil OCR dengan matching yang lebih fleksibel
     */
    private function validateExtractedText(
        string $text, 
        string $nikNim, 
        string $namaLengkap, 
        string $jenisDokumen,
        ?string $emailMahasiswa = null
    ): array {
        // Normalize text
        $normalizedText = preg_replace('/\s+/', ' ', strtolower($text));
        $normalizedNama = preg_replace('/\s+/', ' ', strtolower($namaLengkap));
        
        // Split nama into words
        $namaWords = explode(' ', $normalizedNama);
        $namaWords = array_filter($namaWords, fn($word) => strlen($word) > 2);
        $minMatchWords = max(1, ceil(count($namaWords) * 0.5));

        if ($jenisDokumen === 'ktm') {
            return $this->validateKTM($normalizedText, $nikNim, $namaWords, $minMatchWords, $emailMahasiswa, $text);
        } else {
            return $this->validateKTP($normalizedText, $nikNim, $namaWords, $minMatchWords, $text);
        }
    }

    /**
     * Validasi khusus KTM dengan pengecekan email-NIM
     */
    private function validateKTM(
        string $normalizedText, 
        string $nikNim, 
        array $namaWords, 
        int $minMatchWords,
        ?string $emailMahasiswa,
        string $originalText
    ): array {
        // Check universitas
        $hasUnivName = str_contains($normalizedText, 'universitas dian nuswantoro') || 
                      str_contains($normalizedText, 'dian nuswantoro') ||
                      str_contains($normalizedText, 'udinus');
        
        // Check NIM dengan berbagai format
        $nimClean = preg_replace('/[.\s-]/', '', strtolower($nikNim));
        $textClean = preg_replace('/[.\s-]/', '', $normalizedText);
        
        $hasNim = str_contains($textClean, $nimClean) ||
                 str_contains($normalizedText, strtolower($nikNim));
        
        // Check nama - flexible matching
        $matchedWords = 0;
        foreach ($namaWords as $word) {
            if (str_contains($normalizedText, $word)) {
                $matchedWords++;
            }
        }
        $hasNama = $matchedWords >= $minMatchWords;

        // Validasi Email dengan NIM (jika email disediakan)
        $emailNimMatch = true;
        $emailNimMessage = '';
        
        if ($emailMahasiswa && str_ends_with($emailMahasiswa, '@mhs.dinus.ac.id')) {
            $emailNimMatch = $this->validateEmailWithNIM($emailMahasiswa, $nikNim);
            
            if (!$emailNimMatch) {
                $emailNimMessage = 'Email dan NIM tidak sesuai. ';
            }
        }

        // Hasil validasi
        if ($hasUnivName && $hasNim && $hasNama && $emailNimMatch) {
            return [
                'success' => true,
                'message' => 'Verifikasi KTM berhasil!',
                'user_message' => 'KTM Anda telah berhasil diverifikasi. Data sesuai dengan yang Anda masukkan.',
                'extracted_text' => $originalText,
                'detected_type' => 'ktm',
                'match_details' => [
                    'universitas' => true,
                    'nim' => true,
                    'nama' => true,
                    'email_nim_match' => $emailNimMatch,
                    'matched_words' => $matchedWords . '/' . count($namaWords)
                ]
            ];
        }

        // Compile error messages
        $missing = [];
        if (!$hasUnivName) $missing[] = 'Nama Universitas Dian Nuswantoro tidak terdeteksi';
        if (!$hasNim) $missing[] = 'NIM (' . $nikNim . ') tidak ditemukan pada KTM';
        if (!$hasNama) $missing[] = 'Nama lengkap tidak cocok (ditemukan ' . $matchedWords . '/' . count($namaWords) . ' kata)';
        if (!$emailNimMatch) $missing[] = $emailNimMessage;

        $userMessage = 'Verifikasi KTM gagal. ' . implode('. ', $missing) . '.';
        $userMessage .= ' Pastikan foto KTM jelas dan data yang Anda masukkan sesuai dengan KTM.';

        return [
            'success' => false,
            'message' => 'KTM validation failed',
            'user_message' => $userMessage,
            'extracted_text' => $originalText,
            'detected_type' => 'ktm',
            'type' => 'validation_failed',
            'match_details' => [
                'universitas' => $hasUnivName,
                'nim' => $hasNim,
                'nama' => $hasNama,
                'email_nim_match' => $emailNimMatch,
                'matched_words' => $matchedWords . '/' . count($namaWords)
            ]
        ];
    }

    /**
     * Validasi khusus KTP
     */
    private function validateKTP(
        string $normalizedText, 
        string $nikNim, 
        array $namaWords, 
        int $minMatchWords,
        string $originalText
    ): array {
        // Check NIK
        $nikClean = preg_replace('/[.\s-]/', '', strtolower($nikNim));
        $textClean = preg_replace('/[.\s-]/', '', $normalizedText);
        
        $hasNik = str_contains($textClean, $nikClean) ||
                 str_contains($normalizedText, strtolower($nikNim));
        
        // Check nama
        $matchedWords = 0;
        foreach ($namaWords as $word) {
            if (str_contains($normalizedText, $word)) {
                $matchedWords++;
            }
        }
        $hasNama = $matchedWords >= $minMatchWords;

        if ($hasNik && $hasNama) {
            return [
                'success' => true,
                'message' => 'Verifikasi KTP berhasil!',
                'user_message' => 'KTP Anda telah berhasil diverifikasi. Data sesuai dengan yang Anda masukkan.',
                'extracted_text' => $originalText,
                'detected_type' => 'ktp',
                'match_details' => [
                    'nik' => true,
                    'nama' => true,
                    'matched_words' => $matchedWords . '/' . count($namaWords)
                ]
            ];
        }

        $missing = [];
        if (!$hasNik) $missing[] = 'NIK (' . $nikNim . ') tidak ditemukan pada KTP';
        if (!$hasNama) $missing[] = 'Nama lengkap tidak cocok (ditemukan ' . $matchedWords . '/' . count($namaWords) . ' kata)';

        $userMessage = 'Verifikasi KTP gagal. ' . implode('. ', $missing) . '.';
        $userMessage .= ' Pastikan foto KTP jelas dan data yang Anda masukkan sesuai dengan KTP.';

        return [
            'success' => false,
            'message' => 'KTP validation failed',
            'user_message' => $userMessage,
            'extracted_text' => $originalText,
            'detected_type' => 'ktp',
            'type' => 'validation_failed',
            'match_details' => [
                'nik' => $hasNik,
                'nama' => $hasNama,
                'matched_words' => $matchedWords . '/' . count($namaWords)
            ]
        ];
    }

    /**
     * Validasi kecocokan Email dengan NIM
     * Format Email: 111202315194@mhs.dinus.ac.id
     * Format NIM: A11.2023.15194
     * 
     * Logika konversi UDINUS:
     * A → 1 (A11 → 111)
     * B → 11 (B11 → 1111)
     * C → 21 (C11 → 2111)
     * D → 31 (D11 → 3111)
     * E → 41 (E11 → 4111)
     */
    private function validateEmailWithNIM(string $email, string $nim): bool
    {
        // Ambil bagian sebelum @ dari email
        $emailPart = explode('@', $email)[0];
        
        // Parse NIM: A11.2023.15194
        // Ambil huruf pertama (fakultas), kode prodi, tahun, nomor urut
        $nimClean = strtoupper(trim($nim));
        
        // Extract komponen NIM
        if (!preg_match('/^([A-E])(\d{2})\.(\d{4})\.(\d+)$/', $nimClean, $matches)) {
            return false;
        }
        
        $fakultas = $matches[1];  // A, B, C, D, atau E
        $prodi = $matches[2];     // 11
        $tahun = $matches[3];     // 2023
        $nomorUrut = $matches[4]; // 15194
        
        // Konversi huruf fakultas ke angka
        $fakultasMap = [
            'A' => '1',   // FIK
            'B' => '11',  // FEB
            'C' => '21',  // FIB
            'D' => '31',  // FKES
            'E' => '41',  // FT
        ];
        
        if (!isset($fakultasMap[$fakultas])) {
            return false;
        }
        
        // Buat email yang expected: [fakultas_angka][prodi][tahun][nomor_urut]
        $expectedEmail = $fakultasMap[$fakultas] . $prodi . $tahun . $nomorUrut;
        
        // Bandingkan dengan email yang diinput
        return $emailPart === $expectedEmail;
    }

    /**
     * Menyimpan data toko baru dengan verifikasi KTP/KTM
     */
    public function store(Request $request): RedirectResponse
    {
        if (Auth::user()->toko()->exists()) {
             return redirect()->route('profile')->with('error', 'Anda sudah terdaftar memiliki toko.');
        }

        $validated = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255', 'unique:toko,nama_toko'],
            'no_hp_toko' => ['required', 'string', 'max:20'], 
            'email_mahasiswa' => [
                'required', 'string', 'email', 'max:255', 
                Rule::unique('users', 'email_mahasiswa')->ignore(Auth::id(), 'id_user') 
            ],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nik_nim' => ['required', 'string', 'max:50'],
            'jenis_verifikasi' => ['required', 'in:ktp,ktm'],
            'foto_verifikasi' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'logo_toko' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], 
        ], [
            'nama_toko.required' => 'Nama toko wajib diisi.',
            'nama_toko.unique' => 'Nama toko ini sudah digunakan.',
            'no_hp_toko.required' => 'Nomor handphone toko wajib diisi.',
            'email_mahasiswa.required' => 'Email mahasiswa wajib diisi.',
            'email_mahasiswa.email' => 'Format email mahasiswa tidak valid.',
            'email_mahasiswa.unique' => 'Email mahasiswa ini sudah digunakan.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi.',
            'nik_nim.required' => 'NIK/NIM wajib diisi.',
            'foto_verifikasi.required' => 'Foto KTP/KTM wajib diupload.',
            'foto_verifikasi.*' => 'Foto verifikasi tidak valid (JPG/PNG/WEBP, maks 5MB).',
            'logo_toko.*' => 'Logo tidak valid (JPG/PNG/WEBP, maks 2MB).',
        ]);

        // Validasi email untuk KTM harus @mhs.dinus.ac.id
        if ($validated['jenis_verifikasi'] === 'ktm') {
            if (!str_ends_with($validated['email_mahasiswa'], '@mhs.dinus.ac.id')) {
                return back()->withErrors([
                    'email_mahasiswa' => 'Untuk verifikasi KTM, email harus berformat @mhs.dinus.ac.id'
                ])->withInput();
            }
        }

        $user = Auth::user();
        $user->email_mahasiswa = $validated['email_mahasiswa'];
        $user->save(); 

        $storeData = [
            'id_user' => $user->id_user,
            'nama_toko' => $validated['nama_toko'],
            'no_hp_toko' => $validated['no_hp_toko'],
            'nama_lengkap' => $validated['nama_lengkap'],
            'nik_nim' => $validated['nik_nim'],
            'jenis_verifikasi' => $validated['jenis_verifikasi'],
            'is_verified' => true,
        ];

        // Upload Foto Verifikasi
        if ($request->hasFile('foto_verifikasi')) {
            $file = $request->file('foto_verifikasi');
            $fileName = 'verifikasi_' . time() . '_' . $user->id_user . '.' . $file->getClientOriginalExtension();
            $path = public_path('img/verifikasi');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true, true);
            }
            
            try {
                $file->move($path, $fileName);
                $storeData['foto_verifikasi'] = $fileName;
            } catch (\Exception $e) {
                return back()->withErrors(['foto_verifikasi' => 'Gagal mengupload foto verifikasi.'])->withInput();
            }
        }

        // Upload Logo Toko
        if ($request->hasFile('logo_toko')) {
            $file = $request->file('logo_toko');
            $fileName = time() . '_' . str_replace(' ', '_', $validated['nama_toko']) . '.' . $file->getClientOriginalExtension();
            $path = public_path('img/logotoko'); 

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true, true);
            }
            
            try {
                $file->move($path, $fileName);
                $storeData['logo_toko'] = $fileName;
            } catch (\Exception $e) {
                return back()->withErrors(['logo_toko' => 'Gagal mengupload logo.'])->withInput();
            }
        }

        Toko::create($storeData);

        return redirect()->route('profil-toko')->with('status', 'Selamat! Toko Anda berhasil dibuat dan terverifikasi.');
    }
}