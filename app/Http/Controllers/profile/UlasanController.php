<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Ulasan;
use App\Models\FotoUlasan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class UlasanController extends Controller
{
    // Menampilkan Form Ulasan
    public function create($id_transaksi, $id_barang)
    {
        $user = Auth::user();

        // 1. Validasi: Pastikan transaksi milik user ini
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)
                              ->where('id_user', $user->id_user)
                              ->where('status_pengiriman', 'selesai') // Hanya yang selesai
                              ->firstOrFail();

        // 2. Ambil data barang
        $barang = Barang::findOrFail($id_barang);

        // 3. Cek apakah sudah pernah diulas (opsional, jika 1 barang 1 ulasan)
        $existingUlasan = Ulasan::where('id_transaksi', $id_transaksi)
                                ->where('id_barang', $id_barang)
                                ->first();

        if ($existingUlasan) {
            return redirect()->route('pesanan')->with('error', 'Anda sudah mengulas barang ini.');
        }

        return view('page.profile.ulasan-create', compact('transaksi', 'barang'));
    }

    // Menyimpan Ulasan
    public function store(Request $request)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string',
            'foto_ulasan.*' => 'image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Simpan Ulasan Utama
        $ulasan = Ulasan::create([
            'id_user' => Auth::id(),
            'id_transaksi' => $request->id_transaksi,
            'id_barang' => $request->id_barang,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        // Simpan Foto-foto Ulasan (Multiple)
        if ($request->hasFile('foto_ulasan')) {
            $path = public_path('img/fotoulasan');
            if (!File::isDirectory($path)) File::makeDirectory($path, 0775, true, true);

            foreach ($request->file('foto_ulasan') as $file) {
                $fileName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                $file->move($path, $fileName);

                FotoUlasan::create([
                    'id_ulasan' => $ulasan->id_ulasan,
                    'path_foto' => $fileName
                ]);
            }
        }

        return redirect()->route('pesanan')->with('status', 'Terima kasih! Ulasan Anda berhasil dikirim.');
    }
}