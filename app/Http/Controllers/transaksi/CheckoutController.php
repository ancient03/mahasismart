<?php

namespace App\Http\Controllers\transaksi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Alamat;
use App\Models\Transaksi;
use App\Models\DetailTransaksi;
use App\Models\Barang; 
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log; 
use Illuminate\Validation\Rule; 

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index(): View|RedirectResponse
    {
        $user = Auth::user();
        $items = $user->keranjang()->with('toko')->get(); 

        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }

        $alamatList = $user->alamat()->orderByDesc('is_default')->get();

        $totalHarga = $items->sum(function($item) {
            return $item->harga * $item->pivot->kuantitas;
        });

        return view('page.products.checkout', [
            'items' => $items,
            'alamatList' => $alamatList,
            'totalHarga' => $totalHarga
        ]);
    }

    /**
     * Memproses pesanan.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();
        $items = $user->keranjang()->with('toko')->get(); 

        // 1. Validasi
        if ($items->isEmpty()) {
            return redirect()->route('keranjang.index')->with('error', 'Keranjang Anda kosong.');
        }
        
        $request->validate([
            'id_alamat' => ['required', 'integer'], 
        ], [
            'id_alamat.required' => 'Silakan pilih alamat pengiriman terlebih dahulu.'
        ]);

        $idAlamatYangDipilih = $request->input('id_alamat');
        $alamat = Alamat::find($idAlamatYangDipilih);

        if (!$alamat || $alamat->id_user !== $user->id_user) {
            return redirect()->back()
                             ->withInput($request->input())
                             ->withErrors(['id_alamat' => 'Alamat yang Anda pilih tidak valid.']);
        }
        
        // 2. Hitung total harga
        $totalHarga = $items->sum(function($item) {
            return $item->harga * $item->pivot->kuantitas;
        });

        // 3. Buat Transaksi
        try {
            DB::beginTransaction();

            // 3a. Buat 1 baris di tabel 'transaksi' (Induk)
            $transaksi = Transaksi::create([
                'id_user' => $user->id_user,
                'id_alamat' => $alamat->id_alamat, 
                'nomor_invoice' => 'INV/' . now()->format('Ymd') . '/' . $user->id_user . '/' . time(), 
                'total_harga_keseluruhan' => $totalHarga,
                'status_pembayaran' => 'pending', // (Asumsi pembayaran belum selesai)
                
                // 👇 PERUBAHAN DI SINI 👇
                // Status awal sekarang 'belum diproses', bukan 'diproses'
                'status_pengiriman' => 'belum diproses', 
            ]);

            // 3b. Loop keranjang dan pindahkan ke 'detail_transaksi' (Anak)
            foreach ($items as $item) {
                if (!$item->toko) {
                    throw new \Exception('Barang ' . $item->nama_barang . ' tidak memiliki info toko.'); 
                }
                
                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id_transaksi,
                    'id_barang' => $item->id_barang,
                    'id_toko' => $item->toko->id_toko, 
                    'kuantitas' => $item->pivot->kuantitas,
                    'harga_saat_transaksi' => $item->harga,
                ]);
            }

            // 3c. Kosongkan keranjang user
            $user->keranjang()->detach();

            // 3d. Commit
            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Gagal checkout: ' . $e->getMessage());
            return redirect()->route('keranjang.index')->with('error', 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.');
        }

        // 4. Redirect ke halaman "Pesanan Saya"
        return redirect()->route('pesanan')->with('status', 'Pesanan Anda berhasil dibuat!');
    }
}

