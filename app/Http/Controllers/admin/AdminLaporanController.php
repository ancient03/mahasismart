<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Laporan;

class AdminLaporanController extends Controller
{
    public function index()
    {
        $laporanList = Laporan::with(['user', 'transaksi'])->latest()->paginate(10);
        return view('page.admin.laporan', compact('laporanList'));
    }

    public function updateStatus(Request $request, Laporan $laporan)
    {
        $request->validate([
            'status_laporan' => 'required|in:selesai,ditolak,pending'
        ]);

        $laporan->update([
            'status_laporan' => $request->status_laporan
        ]);

        // Disini Anda bisa menambahkan logika tambahan
        // Misal: Jika 'selesai', update saldo toko (kurangi saldo) atau refund user.

        return back()->with('status', 'Status laporan berhasil diperbarui.');
    }
}