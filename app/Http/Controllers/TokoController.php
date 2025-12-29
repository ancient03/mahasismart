<?php

namespace App\Http\Controllers;

use App\Models\Toko;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Kategori;
use App\Models\Barang;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TokoController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function showPublicProfile(Request $request, Toko $toko): View
    {
        // 1. Ambil kategori unik dari produk-produk di toko ini.
        $kategoriProduk = Kategori::whereHas('barang', function ($query) use ($toko) {
            $query->where('id_toko', $toko->id_toko);
        })->orderBy('nama_kategori')->get();
    
        // 2. Query dasar untuk produk di toko ini.
        $barangQuery = Barang::where('id_toko', $toko->id_toko);
    
        // 3. Filter berdasarkan kategori jika ada di request.
        $selectedKategori = null;
        if ($request->filled('kategori')) {
            $barangQuery->where('id_kategori', $request->kategori);
            $selectedKategori = Kategori::find($request->kategori);
        }
    
        // 4. Ambil produk dengan pagination.
        $barangs = $barangQuery->latest()->paginate(12); // misalnya 12 produk per halaman
    
        // 5. Kirim data ke view.
        return view('page.products.detailtoko', [
            'toko' => $toko,
            'barangs' => $barangs,
            'kategoriProduk' => $kategoriProduk,
            'selectedKategori' => $selectedKategori, // Untuk menampilkan kategori yang aktif
        ]);
    }
}