<?php

// 1. Namespace (pastikan sesuai lokasi folder Anda)
namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller; // Import Controller utama
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user
use Illuminate\View\View;
// (Kita tidak perlu import Model Transaksi di sini karena kita akan memanggilnya via relasi User)

class PesananController extends Controller
{
    /**
     * Menampilkan halaman riwayat pesanan (transaksi) milik pengguna.
     * Dipanggil oleh route GET /pesanan (name: 'pesanan')
     */
    public function index(): View
    {
        // 1. Ambil user yang sedang login
        $user = Auth::user();

        // 2. Ambil semua transaksi milik user tersebut
        // Kita gunakan 'with' (Eager Loading) untuk mengambil data relasi
        // agar lebih efisien dan tidak terjadi N+1 query problem.
        $transaksiList = $user->transaksi() // Panggil relasi 'transaksi()' di Model User
            ->with([
                // 'alamat', // (Opsional) Ambil info alamat pengiriman (jika relasi 'alamat' ada di Model Transaksi)
                
                // Ambil item detail -> lalu ambil info barang -> lalu ambil info toko
                // Ini PENTING untuk view Anda agar tidak error
                'detailTransaksi.barang.toko' 
            ])
            ->latest() // Urutkan dari yang terbaru (berdasarkan created_at)
            ->paginate(10); // Bagi per halaman (misal: 10 transaksi per halaman)

        // 3. Kirim data transaksi ke view
        // Pastikan path view ini benar: 'resources/views/page/profile/pesanan.blade.php'
        return view('page.profile.pesanan', [
            'transaksiList' => $transaksiList
        ]);
    }

    /**
     * (Opsional) Menampilkan detail satu pesanan spesifik.
     * Anda bisa buat rute 'pesanan.show' untuk ini nanti.
     */
    // public function show($id_transaksi): View
    // {
    //     $transaksi = Auth::user()->transaksi()
    //         ->with(['alamat', 'detailTransaksi.barang.toko'])
    //         ->findOrFail($id_transaksi); // Cari atau error 404
            
    //     return view('page.profile.pesanan-detail', [
    //         'transaksi' => $transaksi
    //     ]);
    // }
}

