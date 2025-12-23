<?php

namespace App\Http\Controllers\toko; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DetailTransaksi;
use App\Models\Notification;
use App\Models\Transaksi;       
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule; 

class PesananMasukController extends Controller
{
    /**
     * Menampilkan daftar pesanan yang masuk ke toko user.
     */
    public function index(): View | RedirectResponse
    {
        $toko = Auth::user()->toko()->first();
        if (!$toko) {
            return redirect()->route('profile')->with('error', 'Anda harus memiliki toko untuk melihat pesanan masuk.');
        }

        $itemList = DetailTransaksi::where('id_toko', $toko->id_toko)
            ->with(['barang', 'transaksi.user']) 
            ->latest('id_detail_transaksi') 
            ->paginate(15); 

        return view('page.toko.pesanan-masuk', [
            'itemList' => $itemList
        ]);
    }

    /**
     * Mengupdate status pengiriman dari sebuah transaksi.
     */
    public function updateStatus(Request $request, Transaksi $transaksi): RedirectResponse
    {
        $validated = $request->validate([
            'status_pengiriman' => ['required', 'string', Rule::in(['diproses', 'dikirim', 'selesai', 'dibatalkan'])],
        ]);
        
        $userTokoId = Auth::user()->toko?->id_toko;
        
        $isOwner = $transaksi->detailTransaksi() 
                            ->where('id_toko', $userTokoId) 
                            ->exists(); 
                            
        if (!$isOwner) {
            abort(403, 'Anda tidak berhak mengubah status pesanan ini.');
        }
        
        $transaksi->update([
            'status_pengiriman' => $validated['status_pengiriman']
        ]);

        // Kirim notifikasi ke pembeli
        Notification::create([
            'id_user' => $transaksi->id_user,
            'title' => 'Status Pesanan Diperbarui',
            'message' => 'Status pesanan ' . $transaksi->nomor_invoice . ' telah diubah menjadi "' . $validated['status_pengiriman'] . '".',
            'url' => route('pesanan.show', $transaksi->id_transaksi)
        ]);


        // 👇 PERBAIKAN DI SINI: Ganti 'pesanan-masuk' menjadi 'pesanan-masuk.index' 👇
        return redirect()->route('toko.pesanan-masuk')->with('status', 'Status pesanan berhasil diperbarui!');
    }

    /**
     * Menampilkan detail satu pesanan masuk.
     */
    public function show(Transaksi $transaksi): View
    {
        $userTokoId = Auth::user()->toko?->id_toko;
        
        $detailMilikToko = $transaksi->detailTransaksi()
                                     ->where('id_toko', $userTokoId)
                                     ->with('barang')
                                     ->get();

        if ($detailMilikToko->isEmpty()) {
            abort(403, 'Anda tidak memiliki akses ke pesanan ini.');
        }

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