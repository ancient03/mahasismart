<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class KeranjangController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja (halaman utama).
     * Dipanggil oleh route GET /keranjang
     */
    public function index(): View
    {
        $user = Auth::user();
        
        // Ambil semua item di keranjang user,
        // dan muat relasi 'barang' serta 'barang.toko' (eager loading)
        $items = Keranjang::where('id_user', $user->id_user)
                            ->with('barang', 'barang.toko')
                            ->get();

        // Hitung total harga
        $totalHarga = $items->sum(function($item) {
            // Pastikan item->barang tidak null sebelum mengakses harga
            if ($item->barang) {
                return $item->barang->harga * $item->kuantitas;
            }
            return 0;
        });

        // Kirim data ke view
        // Pastikan path view ini benar: 'resources/views/page/products/chart.blade.php'
        return view('page.products.chart', [
            'items' => $items,
            'totalHarga' => $totalHarga
        ]);
    }

    /**
     * Menambah barang ke keranjang.
     * Dipanggil oleh route POST /keranjang/tambah/{barang}
     */
    public function store(Request $request, Barang $barang): RedirectResponse
    {
        $user = Auth::user();
        $kuantitas = $request->input('kuantitas', 1); // Ambil kuantitas dari form, default 1

        // 1. Cek apakah user sudah punya barang ini di keranjang
        $existingItem = Keranjang::where('id_user', $user->id_user)
                                   ->where('id_barang', $barang->id_barang)
                                   ->first();

        if ($existingItem) {
            // 2. Jika sudah ada, tambahkan kuantitasnya
            $existingItem->kuantitas += $kuantitas;
            $existingItem->save();
        } else {
            // 3. Jika belum ada, buat baris baru
            Keranjang::create([
                'id_user' => $user->id_user,
                'id_barang' => $barang->id_barang,
                'kuantitas' => $kuantitas
            ]);
        }

        // 4. Kembali ke halaman sebelumnya dengan pesan sukses
       return redirect()->route('keranjang.index')->with('status', 'Barang berhasil ditambahkan ke keranjang!');
    }

    /**
     * Mengupdate kuantitas barang di keranjang.
     * Dipanggil oleh route PATCH /keranjang/update/{id_barang}
     */
    public function update(Request $request, $id_barang): RedirectResponse
    {
        $user = Auth::user();
        
        $item = Keranjang::where('id_user', $user->id_user)
                         ->where('id_barang', $id_barang)
                         ->firstOrFail(); // Akan error jika tidak ditemukan

        $newKuantitas = $request->input('kuantitas');

        if ($newKuantitas > 0) {
            $item->kuantitas = $newKuantitas;
            $item->save();
        } else {
            // Jika kuantitas 0 atau kurang, hapus item
            $item->delete();
        }

        // Redirect kembali ke halaman keranjang
        return redirect()->route('keranjang.index');
    }

    /**
     * Menghapus barang dari keranjang.
     * Dipanggil oleh route DELETE /keranjang/hapus/{id_barang}
     */
    public function destroy($id_barang): RedirectResponse
    {
        $user = Auth::user();

        // Hapus item dari keranjang
        Keranjang::where('id_user', $user->id_user)
                 ->where('id_barang', $id_barang)
                 ->delete();

        return redirect()->route('keranjang.index')->with('status', 'Barang dihapus dari keranjang.');
    }
}
