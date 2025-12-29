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
            ]);

            $image = $request->file('image');
            $nikNim = $request->input('nik_nim');
            $namaLengkap = strtolower($request->input('nama_lengkap'));
            $jenisDokumen = $request->input('jenis_dokumen');

            // OCR.space API Call
            $ocrApiKey = env('OCR_KEY');
            
            if (!$ocrApiKey) {
                return response()->json([
                    'success' => false,
                    'message' => 'OCR API key tidak ditemukan. Hubungi administrator.'
                ], 500);
            }

            // METHOD 1: Kirim file langsung (LEBIH RELIABLE)
            $response = Http::attach(
                'file',
                file_get_contents($image->getRealPath()),
                $image->getClientOriginalName()
            )->post('https://api.ocr.space/parse/image', [
                'apikey' => $ocrApiKey,
                'language' => 'eng',             // OCR.space hanya support: eng, ara, chs, cht, cze, dan, dut, fin, fre, ger, gre, hun, kor, ita, jpn, pol, por, rus, spa, swe, tur
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
                    'message' => 'Gagal menghubungi OCR service. Status: ' . $response->status()
                ], 500);
            }

            $ocrResult = $response->json();

            // Debug log
            \Log::info('OCR Response', ['result' => $ocrResult]);

            // Check for OCR errors
            if (isset($ocrResult['IsErroredOnProcessing']) && $ocrResult['IsErroredOnProcessing']) {
                $errorMessage = $ocrResult['ErrorMessage'][0] ?? 'Unknown OCR error';
                return response()->json([
                    'success' => false,
                    'message' => 'OCR Error: ' . $errorMessage
                ], 400);
            }

            if (!isset($ocrResult['ParsedResults'][0]['ParsedText'])) {
                return response()->json([
                    'success' => false,
                    'message' => 'Tidak dapat membaca teks dari gambar. Pastikan foto jelas dan tidak blur.',
                    'debug' => $ocrResult
                ], 400);
            }

            $extractedText = strtolower($ocrResult['ParsedResults'][0]['ParsedText']);
            
            // Check if text is too short (likely failed OCR)
            if (strlen($extractedText) < 20) {
                return response()->json([
                    'success' => false,
                    'message' => 'Teks yang terbaca terlalu sedikit. Pastikan foto jelas dan terang.',
                    'debug' => $extractedText
                ], 400);
            }

            // Validasi berdasarkan jenis dokumen
            $validation = $this->validateExtractedText($extractedText, $nikNim, $namaLengkap, $jenisDokumen);

            return response()->json($validation);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal: ' . implode(', ', $e->errors()['image'] ?? ['File tidak valid'])
            ], 422);
        } catch (\Exception $e) {
            \Log::error('OCR Validation Error: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Validasi hasil OCR
     */
    private function validateExtractedText(string $text, string $nikNim, string $namaLengkap, string $jenisDokumen): array
    {
        // Normalize text - remove extra spaces and newlines
        $normalizedText = preg_replace('/\s+/', ' ', strtolower($text));
        $normalizedNama = preg_replace('/\s+/', ' ', strtolower($namaLengkap));
        
        // Split nama into words for flexible matching
        $namaWords = explode(' ', $normalizedNama);
        $namaWords = array_filter($namaWords, fn($word) => strlen($word) > 2); // Filter kata pendek
        $minMatchWords = max(1, ceil(count($namaWords) * 0.5)); // At least 50% of words must match

        if ($jenisDokumen === 'ktm') {
            // Validasi KTM
            $hasUnivName = str_contains($normalizedText, 'universitas dian nuswantoro') || 
                          str_contains($normalizedText, 'dian nuswantoro') ||
                          str_contains($normalizedText, 'udinus');
            
            // Check NIM - be more flexible
            $nimClean = preg_replace('/[.\s-]/', '', strtolower($nikNim)); // Remove dots, spaces, dashes
            $textClean = preg_replace('/[.\s-]/', '', $normalizedText);
            
            $hasNim = str_contains($textClean, $nimClean) ||
                     str_contains($normalizedText, strtolower($nikNim));
            
            // Check name - flexible matching
            $matchedWords = 0;
            foreach ($namaWords as $word) {
                if (str_contains($normalizedText, $word)) {
                    $matchedWords++;
                }
            }
            $hasNama = $matchedWords >= $minMatchWords;

            if ($hasUnivName && $hasNim && $hasNama) {
                return [
                    'success' => true,
                    'message' => 'KTM berhasil diverifikasi!',
                    'extracted_text' => $text,
                    'detected_type' => 'ktm',
                    'match_details' => [
                        'universitas' => true,
                        'nim' => true,
                        'nama' => true,
                        'matched_words' => $matchedWords . '/' . count($namaWords)
                    ]
                ];
            }

            $missing = [];
            if (!$hasUnivName) $missing[] = 'Nama Universitas Dian Nuswantoro';
            if (!$hasNim) $missing[] = 'NIM (' . $nikNim . ')';
            if (!$hasNama) $missing[] = 'Nama lengkap (ditemukan ' . $matchedWords . '/' . count($namaWords) . ' kata)';

            return [
                'success' => false,
                'message' => 'Verifikasi KTM gagal. Tidak ditemukan: ' . implode(', ', $missing),
                'extracted_text' => $text,
                'detected_type' => 'ktm',
                'debug' => substr($normalizedText, 0, 300),
                'match_details' => [
                    'universitas' => $hasUnivName,
                    'nim' => $hasNim,
                    'nama' => $hasNama,
                    'matched_words' => $matchedWords . '/' . count($namaWords)
                ]
            ];
        } else {
            // Validasi KTP
            $nikClean = preg_replace('/[.\s-]/', '', strtolower($nikNim));
            $textClean = preg_replace('/[.\s-]/', '', $normalizedText);
            
            $hasNik = str_contains($textClean, $nikClean) ||
                     str_contains($normalizedText, strtolower($nikNim));
            
            // Check name - flexible matching
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
                    'message' => 'KTP berhasil diverifikasi!',
                    'extracted_text' => $text,
                    'detected_type' => 'ktp',
                    'match_details' => [
                        'nik' => true,
                        'nama' => true,
                        'matched_words' => $matchedWords . '/' . count($namaWords)
                    ]
                ];
            }

            $missing = [];
            if (!$hasNik) $missing[] = 'NIK (' . $nikNim . ')';
            if (!$hasNama) $missing[] = 'Nama lengkap (ditemukan ' . $matchedWords . '/' . count($namaWords) . ' kata)';

            return [
                'success' => false,
                'message' => 'Verifikasi KTP gagal. Tidak ditemukan: ' . implode(', ', $missing),
                'extracted_text' => $text,
                'detected_type' => 'ktp',
                'debug' => substr($normalizedText, 0, 300),
                'match_details' => [
                    'nik' => $hasNik,
                    'nama' => $hasNama,
                    'matched_words' => $matchedWords . '/' . count($namaWords)
                ]
            ];
        }
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

        // Upload Foto Verifikasi KTP/KTM
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

        // Upload Logo Toko (Opsional)
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