<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class ProfileController extends Controller
{
    /**
     * Menampilkan halaman edit profil.
     */
    public function edit()
    {
        // Mengarahkan ke file view profil Anda
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
            // 'username' harus unik, KECUALI untuk user_id ini
            'username' => [
                'required', 'string', 'max:255',
                Rule::unique('users')->ignore($user->id_user, 'id_user')
            ],
            // 'email' harus unik, KECUALI untuk user_id ini
            'email' => [
                'required', 'string', 'email', 'max:255',
                Rule::unique('users')->ignore($user->id_user, 'id_user')
            ],
            // 'no_hp' harus unik, KECUALI untuk user_id ini
            'no_hp' => [
                'nullable', 'string', 'max:255',
                Rule::unique('users')->ignore($user->id_user, 'id_user')
            ],
            // Password bersifat opsional. Jika diisi, harus dikonfirmasi.
            'password' => ['nullable', 'confirmed', Rules\Password::defaults()],
        ]);

        // 2. Siapkan data untuk di-update
        $updateData = [
            'username' => $validated['username'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
        ];

        // 3. Hanya update password JIKA diisi
        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        // 4. Update user di database
        $user->update($updateData);

        // 5. Kembali ke halaman profil dengan pesan sukses
        return redirect()->route('profile')->with('status', 'Profil berhasil diperbarui!');
    }
}