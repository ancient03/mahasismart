<?php

namespace App\Http\Controllers\toko; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Toko;
use App\Models\User; 
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;
// 👇 TAMBAHKAN IMPORT INI 👇
use Illuminate\Http\RedirectResponse; 

class RegisterTokoController extends Controller 
{
    /**
     * Menampilkan form registrasi toko.
     * Sekarang bisa return View ATAU RedirectResponse
     */
    // 👇 UBAH RETURN TYPE HINT DI SINI 👇
    public function create(): View|RedirectResponse 
    {
        if (Auth::user()->toko()->exists()) {
            // Ini mengembalikan RedirectResponse, sekarang sudah valid
            return redirect()->route('profile')->with('error', 'Anda sudah terdaftar memiliki toko.');
        }
        // Ini mengembalikan View, juga valid
        return view('page.profile.register-toko'); 
    }

    /**
     * Menyimpan data toko baru DAN email mahasiswa.
     */
    public function store(Request $request): RedirectResponse
    {
        // ... (Kode method store Anda tetap sama) ...
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
            'logo_toko' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], 
        ], [
            'nama_toko.required' => 'Nama toko wajib diisi.',
            'nama_toko.unique' => 'Nama toko ini sudah digunakan.',
            'no_hp_toko.required' => 'Nomor handphone toko wajib diisi.',
            'email_mahasiswa.required' => 'Email mahasiswa wajib diisi.',
            'email_mahasiswa.email' => 'Format email mahasiswa tidak valid.',
            'email_mahasiswa.unique' => 'Email mahasiswa ini sudah digunakan oleh user lain.',
            'logo_toko.*' => 'Logo tidak valid (JPG/PNG/WEBP, maks 2MB).',
        ]);

        $user = Auth::user();
        $user->email_mahasiswa = $validated['email_mahasiswa'];
        $user->save(); 

        $storeData = [
            'id_user' => $user->id_user,
            'nama_toko' => $validated['nama_toko'],
            'no_hp_toko' => $validated['no_hp_toko'],
        ];

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
                return back()->withErrors(['logo_toko' => 'Gagal mengupload logo. Periksa permission folder.'])->withInput();
            }
        }

        Toko::create($storeData);

         return redirect()->route('profil-toko')->with('status', 'Selamat! Toko Anda berhasil dibuat dan email mahasiswa tersimpan.');
    }
}

