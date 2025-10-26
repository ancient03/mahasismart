<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\File; 

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil.
     */
    public function edit()
    {
        return view('page.profile.profile', [
            'user' => Auth::user()
        ]);
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 1. Validasi Data
        $validated = $request->validate([
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique('users')->ignore($user->id_user, 'id_user')
            ],
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id_user, 'id_user')
            ],
            'no_hp' => [
                'nullable', 'string', 'max:255',
                Rule::unique('users')->ignore($user->id_user, 'id_user')
            ],
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
            
            // 2. TAMBAHKAN VALIDASI FOTO PROFIL
            'foto_profil' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // Max 2MB
        ]);

        // 3. Siapkan data untuk di-update (data teks)
        $updateData = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
        ];

        // 4. Hanya update password JIKA diisi
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // 5. LOGIKA UPLOAD FOTO PROFIL (BARU)
        if ($request->hasFile('foto_profil')) {
            
            $file = $request->file('foto_profil');
            
            // Buat nama file unik: timestamp + username + extensi
            $fileName = time() . '_' . $user->username . '.' . $file->getClientOriginalExtension();
            
            // Tentukan path tujuan
            $path = public_path('img/fotoprofile');

            // Hapus file lama jika ada
            if ($user->foto_profil) {
                $oldFilePath = $path . '/' . $user->foto_profil;
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            // Pindahkan file baru ke 'public/img/fotoprofile/'
            $file->move($path, $fileName);

            // Simpan nama file baru ke database
            $updateData['foto_profil'] = $fileName;
        }

        // 6. Update user di database
        $user->update($updateData);

        // 7. Kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile')->with('status', 'Profil berhasil diperbarui!');
    }
}