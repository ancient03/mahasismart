<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang; // Import model Barang
use App\Models\Kategori;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Menampilkan halaman utama dengan semua produk.
     */
    public function index(): View
    {
        // Ambil semua barang, eager load relasi 'toko'
        // Anda bisa menambahkan ->latest() atau ->orderBy() jika perlu
        // Anda juga bisa menambahkan ->paginate(12) untuk pagination
        $barangList = Barang::with('toko')->latest()->paginate(12); // Contoh: Ambil 12 terbaru per halaman
        
        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        // Kirim data ke view home
        // Pastikan path view 'page.home' benar
        return view('page.home', [
            'barangList' => $barangList ,
            'kategoriList' => $kategoriList 
        ]);
    }
}
