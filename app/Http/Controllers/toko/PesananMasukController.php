<?php

// 1. Namespace (sesuai lokasi folder)
namespace App\Http\Controllers\toko; 

use App\Http\Controllers\Controller; // Import Controller utama
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailTransaksi; // Kita akan ambil data dari sini
use App\Models\Transaksi;       // Kita perlu update status di sini
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule; // Untuk validasi status

class PesananMasukController extends Controller
{
    /**
     * Menampilkan daftar pesanan yang masuk ke toko user.
     */
    public function index(): View | RedirectResponse
    {
        // 1. Dapatkan toko milik user yang login
        $toko = Auth::user()->toko()->first();
        if (!$toko) {
            // Jika tidak punya toko, kembalikan ke profil
            return redirect()->route('profile')->with('error', 'Anda harus memiliki toko untuk melihat pesanan masuk.');
        }

        // 2. Ambil semua item detail transaksi (DetailTransaksi) yang id_toko-nya
        //    milik toko yang sedang login.
        $itemList = DetailTransaksi::where('id_toko', $toko->id_toko)
            ->with(['barang', 'transaksi.user']) // Ambil info barang, info transaksi induk, dan info pembeli
            ->latest('id_detail_transaksi') // Tampilkan yang terbaru
            ->paginate(15); // Paginasi

        // 3. Kirim data ke view
        // Pastikan path view ini benar: 'resources/views/page/toko/pesanan-masuk.blade.php'
        return view('page.toko.pesanan-masuk', [
            'itemList' => $itemList
        ]);
    }

    /**
     * Mengupdate status pengiriman dari sebuah transaksi.
     * (Dipanggil oleh tombol "Terima Pesanan", "Tandai Dikirim", "Tandai Selesai")
     */
    public function updateStatus(Request $request, Transaksi $transaksi): RedirectResponse
    {
        // 1. Validasi input (pastikan status yang dikirim valid)
        //    Status baru yang diizinkan (sesuai alur baru Anda)
        $validated = $request->validate([
            'status_pengiriman' => ['required', 'string', Rule::in(['diproses', 'dikirim', 'selesai', 'dibatalkan'])],
        ]);
        
        // 2. Otorisasi: Pastikan toko yang login ini 
        //    memang punya item di dalam transaksi yang akan diubah.
        $userTokoId = Auth::user()->toko?->id_toko;
        
        $isOwner = $transaksi->detailTransaksi() // Ambil semua item di transaksi ini
                            ->where('id_toko', $userTokoId) // Cek apakah ada yg id_toko-nya = id toko kita
                            ->exists(); // 'exists()' mengembalikan true jika ada
                            
        if (!$isOwner) {
            abort(403, 'Anda tidak berhak mengubah status pesanan ini.');
        }
        
        // 3. Update status di tabel Transaksi (Induk)
        $transaksi->update([
            'status_pengiriman' => $validated['status_pengiriman']
        ]);

        // 4. Redirect kembali dengan pesan sukses
        return redirect()->route('pesanan-masuk')->with('status', 'Status pesanan berhasil diperbarui!');
    }
    
/**
     * Menampilkan detail satu pesanan masuk.
     */
    public function show(Transaksi $transaksi): View
    {
        // 1. Otorisasi: Pastikan toko ini punya item di dalam transaksi ini
        $userTokoId = Auth::user()->toko?->id_toko;
        
        // Ambil hanya item yang milik toko ini
        $detailMilikToko = $transaksi->detailTransaksi()
                                     ->where('id_toko', $userTokoId)
                                     ->with('barang')
                                     ->get();

        if ($detailMilikToko->isEmpty()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

        // 2. Hitung subtotal khusus untuk toko ini (bukan total seluruh transaksi jika ada toko lain)
        $subtotalToko = $detailMilikToko->sum(function($detail) {
            return $detail->harga_saat_transaksi * $detail->kuantitas;
        });

        return view('page.toko.pesanan-masuk-detail', [
            'transaksi' => $transaksi,
            'detailMilikToko' => $detailMilikToko,
            'subtotalToko' => $subtotalToko
        ]);
    }
    
}

