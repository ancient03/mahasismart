<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar semua user.
     */
    public function index(): View
    {
        // Ambil semua user, urutkan dari terbaru
        $userList = User::latest()->paginate(10);

        // Pastikan path view ini benar
        return view('page.admin.list-user', [
            'userList' => $userList
        ]);
    }

    /**
     * Mengubah STATUS (Aktif/Banned) atau ROLE (Admin/User).
     */
    public function updateStatus(Request $request, User $user): RedirectResponse
    {
        // 1. Validasi
        $validated = $request->validate([
            'status_user' => ['nullable', 'in:aktif,banned'],
            'catatan_admin' => ['nullable', 'string', 'max:500'],
            'role' => ['nullable', 'in:admin,user'],
        ]);

        // 2. Logika Update STATUS (Banned/Aktif)
        if ($request->has('status_user')) {
            // Cegah admin mem-banned diri sendiri
            if ($user->id_user === Auth::id()) {
                return redirect()->back()->with('error', 'Anda tidak bisa mem-banned diri sendiri.');
            }

            $user->update([
                'status_user' => $validated['status_user'],
                'catatan_admin' => $validated['catatan_admin'] ?? null,
            ]);
            
            $pesan = 'Status user berhasil diubah menjadi ' . ucfirst($validated['status_user']);
        }

        // 3. Logika Update ROLE (Admin/User)
        if ($request->has('role')) {
            // Cegah admin mengubah role diri sendiri (agar tidak kehilangan akses)
            if ($user->id_user === Auth::id()) {
                return redirect()->back()->with('error', 'Anda tidak bisa mengubah role Anda sendiri.');
            }

            $user->update([
                'role' => $validated['role']
            ]);
            
            $pesan = 'Role user berhasil diubah menjadi ' . ucfirst($validated['role']);
        }

        return redirect()->back()->with('status', $pesan ?? 'Data user diperbarui.');
    }
}