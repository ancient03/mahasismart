<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Iklan;
use Carbon\Carbon;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Ambil semua barang (produk)
        $barangList = Barang::with('toko')->latest()->paginate(12);

        // Ambil semua kategori
        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        // Ambil hanya iklan yang status-nya aktif dan sedang dalam rentang waktu aktif
        $iklanAktif = Iklan::where('status', 'aktif')
            ->where('dimulai', '<=', Carbon::now())
            ->where('berakhir', '>=', Carbon::now())
            ->latest()
            ->get();

        // Kirim semua data ke view
        return view('page.home', [
            'barangList' => $barangList,
            'kategoriList' => $kategoriList,
            'iklanAktif' => $iklanAktif
        ]);
    }

    // Detail iklan
    public function show($id)
    {
        $iklan = Iklan::findOrFail($id);
        return view('page.detail-iklan', compact('iklan'));
    }
}
