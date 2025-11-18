<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminTokoController extends Controller
{
    /**
     * Menampilkan daftar semua toko.
     */
    public function index(): View
    {
        // Ambil semua toko, urutkan dari terbaru
        // Anda bisa tambah fitur pencarian di sini nanti
        $tokoList = Toko::with('user')->latest()->paginate(10);

        // Pastikan path view ini benar: 'resources/views/page/admin/list-toko.blade.php'
        return view('page.admin.list-toko', [
            'tokoList' => $tokoList
        ]);
    }

    /**
     * Mengubah status toko (Aktif, Peringatan, Banned).
     */
    public function updateStatus(Request $request, Toko $toko): RedirectResponse
    {
        // Validasi input
        $validated = $request->validate([
            'status_toko' => ['required', 'in:aktif,peringatan,banned'],
            // Catatan wajib diisi jika memberi peringatan atau banned
            'catatan_admin' => ['nullable', 'string', 'max:500'], 
        ]);

        // Update data toko
        $toko->update([
            'status_toko' => $validated['status_toko'],
            'catatan_admin' => $validated['catatan_admin'] ?? null,
        ]);

        $pesan = 'Status toko berhasil diperbarui menjadi ' . ucfirst($validated['status_toko']);

        return redirect()->back()->with('status', $pesan);
    }
}