<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Ulasan; // <-- Pastikan model Ulasan di-import
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB; // <-- Import DB untuk query raw

class ProductDetailController extends Controller
{
    /**
     * Menampilkan halaman detail untuk satu barang.
     */
    public function show(Barang $barang): View
    {
        // 1. Load relasi dasar (toko & kategori)
        //    Agar kita bisa mengakses $barang->toko->nama_toko, dll.
        $barang->load('toko', 'kategori');

        // 2. Inisialisasi variabel rating (default 0)
        $avgRating = 0;
        $totalRating = 0;
        $ulasanList = collect(); // Koleksi kosong jika tidak ada ulasan

        // 3. Ambil Data Ulasan & Rating
        //    Hanya jalankan jika model Ulasan sudah Anda buat
        if (class_exists(Ulasan::class)) {
            
            // Hitung rata-rata dan total ulasan untuk barang ini
            $stats = Ulasan::where('id_barang', $barang->id_barang)
                ->select(DB::raw('avg(rating) as average, count(*) as count'))
                ->first();
            
            if ($stats) {
                // Format rating jadi 1 desimal (misal 4.5)
                $avgRating = $stats->average ? number_format((float)$stats->average, 1) : 0;
                $totalRating = $stats->count;
            }

            // Ambil daftar ulasan terbaru (beserta user dan fotonya)
            // Pastikan relasi 'user' dan 'fotoUlasan' ada di model Ulasan
            $ulasanList = Ulasan::with(['user', 'fotoUlasan'])
                ->where('id_barang', $barang->id_barang)
                ->latest()
                ->paginate(5); // Tampilkan 5 ulasan per halaman
        }

        // 4. Ambil Rekomendasi Produk
        //    (Barang lain dari kategori yang sama, kecuali barang ini sendiri)
        $rekomendasiList = Barang::where('id_kategori', $barang->id_kategori)
                                  ->where('id_barang', '!=', $barang->id_barang) 
                                  ->with('toko') // Eager load toko agar efisien
                                  ->take(4)      // Ambil 4 produk saja
                                  ->get();

        // 5. Kirim SEMUA variabel ke view
        //    Ini yang paling penting agar tidak error "Undefined variable"
        return view('page.products.detailproduk', [
            'barang' => $barang,
            'toko' => $barang->toko, // Kirim data toko terpisah (opsional, bisa pakai $barang->toko)
            
            // Variabel-variabel ini WAJIB dikirim karena view memanggilnya
            'avgRating' => $avgRating,      
            'totalRating' => $totalRating,  
            'ulasanList' => $ulasanList,    
            
            'rekomendasiList' => $rekomendasiList,
            
            // Tambahan: Kirim total terjual toko (untuk komponen toko)
            'totalTerjualToko' => $this->hitungTotalTerjualToko($barang->toko),
        ]);
    }

    /**
     * Helper untuk menghitung total terjual toko
     */
    private function hitungTotalTerjualToko($toko)
    {
        if (!$toko) return 0;

        // Pastikan relasi detailTransaksi ada di model Toko
        // Dan relasi transaksi ada di model DetailTransaksi
        return $toko->detailTransaksi()
            ->whereHas('transaksi', function ($query) {
                $query->where('status_pengiriman', 'selesai');
            })
            ->sum('kuantitas');
    }
}