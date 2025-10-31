<?php

namespace App\Http\Controllers;

use App\Models\Barang; // Import model Barang
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ProductDetailController extends Controller
{
    /**
     * Menampilkan halaman detail untuk satu barang.
     * Kita menggunakan Route Model Binding (Barang $barang)
     * Laravel akan otomatis mencari Barang berdasarkan ID di URL.
     */
    public function show(Barang $barang): View
    {
        // 1. Load relasi yang diperlukan (toko & kategori)
        // Ini akan mengambil data toko dan kategori yang terkait dengan barang ini
        $barang->load('toko', 'kategori');

        // 2. Ambil data ulasan (jika sudah ada model & relasinya)
        // Untuk saat ini, kita akan kirim array kosong
        // Ganti ini nanti: $ulasanList = $barang->ulasan()->latest()->paginate(10);
        $ulasanList = []; 

        // 3. Ambil data rekomendasi
        // Contoh: ambil 8 barang lain dari kategori yang sama, kecuali barang ini sendiri
        $rekomendasiList = Barang::where('id_kategori', $barang->id_kategori) // Dari kategori yang sama
                                  ->where('id_barang', '!=', $barang->id_barang) // Kecuali barang ini
                                  ->with('toko') // Eager load toko
                                  ->take(8) // Ambil 8 saja
                                  ->get();

        // 4. Kirim semua data ke view
        // Pastikan path view 'page.products.detailproduk' sudah benar
        return view('page.products.detailproduk', [
            'barang' => $barang,
            'toko' => $barang->toko, // Kirim relasi toko
            'deskripsi' => $barang->deskripsi, // Kirim deskripsi
            'ulasanList' => $ulasanList,
            'rekomendasiList' => $rekomendasiList,
        ]);
    }
}

