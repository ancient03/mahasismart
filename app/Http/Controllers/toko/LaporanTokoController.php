<?php

namespace App\Http\Controllers\toko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Laporan;

class LaporanTokoController extends Controller
{
    public function index()
    {
        $toko = Auth::user()->toko;
        
        if (!$toko) {
            return redirect()->route('profile');
        }

        // Cari laporan yang terkait dengan transaksi
        // di mana transaksi tersebut memiliki detail_transaksi dari toko ini
        $laporanList = Laporan::whereHas('transaksi.detailTransaksi', function($q) use ($toko) {
                $q->where('id_toko', $toko->id_toko);
            })
            ->with(['user', 'transaksi'])
            ->latest()
            ->paginate(10);

        return view('page.toko.laporan', compact('laporanList'));
    }
}