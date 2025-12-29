<?php

namespace App\Http\Controllers\toko;

use App\Http\Controllers\Controller;
use App\Models\Retur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReturTokoController extends Controller
{
    /**
     * Menampilkan daftar retur yang masuk ke Toko.
     */
    public function index()
    {
        $user = Auth::user();

        // Pastikan user punya toko
        if (!$user->toko) {
            return redirect()->route('toko.register')->with('error', 'Anda belum memiliki toko.');
        }

        $id_toko = $user->toko->id_toko;

        // Ambil data retur dimana barang (detailTransaksi) adalah milik toko ini
        // Kita gunakan whereHas ke relasi detailTransaksi -> toko
        $returs = Retur::whereHas('detailTransaksi', function ($query) use ($id_toko) {
            $query->where('id_toko', $id_toko);
        })->with(['detailTransaksi.barang', 'detailTransaksi.transaksi.user'])
          ->latest()
          ->paginate(10); // Gunakan paginate agar rapi jika datanya banyak

        return view('page.toko.retur.index', compact('returs'));
    }

    /**
     * Menampilkan detail retur.
     */
    public function show($id)
    {
        $user = Auth::user();
        
        if (!$user->toko) {
            abort(403, 'Anda tidak memiliki akses toko.');
        }
        
        $id_toko = $user->toko->id_toko;

        // Cari Retur dan validasi kepemilikan toko
        $retur = Retur::whereHas('detailTransaksi', function ($query) use ($id_toko) {
            $query->where('id_toko', $id_toko);
        })->with(['detailTransaksi.barang', 'detailTransaksi.transaksi.user'])
          ->findOrFail($id);

        return view('page.toko.retur.show', compact('retur'));
    }

    /**
     * Proses Update Status (Terima / Tolak)
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:disetujui,ditolak',
        ]);

        $user = Auth::user();
        $id_toko = $user->toko->id_toko;

        // Pastikan retur yang mau diupdate benar-benar milik toko ini
        $retur = Retur::whereHas('detailTransaksi', function ($query) use ($id_toko) {
            $query->where('id_toko', $id_toko);
        })->findOrFail($id);

        // Update status
        $retur->status = $request->status;
        $retur->save();

        // (Opsional) Jika disetujui, kamu bisa tambahkan logika lain disini
        // Contoh: Update stok barang, atau kirim notifikasi ke pembeli

        $pesan = $request->status == 'disetujui' ? 'Pengajuan retur diterima.' : 'Pengajuan retur ditolak.';

        return redirect()->route('toko.retur.index')->with('success', $pesan);
    }
}