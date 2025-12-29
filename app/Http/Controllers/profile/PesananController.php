<?php

// 1. Namespace (pastikan sesuai lokasi folder Anda)
namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller; // Import Controller utama
use App\Models\DetailTransaksi;
use App\Models\Retur;
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
     * Menampilkan detail satu pesanan (transaksi) milik user.
     */
    public function show($id): View
    {
        $user = Auth::user();

        // 1. Ambil transaksi berdasarkan ID, pastikan milik user yang login
        $transaksi = $user->transaksi()
            ->with([
                'alamat',
                'detailTransaksi.barang.toko' // Ambil detail -> barang -> toko
            ])
            ->findOrFail($id); // Error 404 jika tidak ditemukan atau bukan milik user

        // 2. Kirim data ke view
        return view('page.profile.pesanan-detail', [
            'transaksi' => $transaksi
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function createRetur(DetailTransaksi $detail_transaksi)
    {
        // TODO: Authorize that the user can return this item.
        // For example, check if the order is completed and within the return window.
        // $this->authorize('create', [Retur::class, $detail_transaksi]);

        return view('page.profile.retur.create', compact('detail_transaksi'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeRetur(Request $request)
    {
        $request->validate([
            'detail_transaksi_id' => 'required|exists:detail_transaksi,id_detail_transaksi',
            'alasan' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);
        
        // TODO: Authorize that the user can return this item.

        $retur = Retur::create([
            'detail_transaksi_id' => $request->detail_transaksi_id,
            'alasan' => $request->alasan,
            'catatan' => $request->catatan,
        ]);

        return redirect()->route('retur.show', $retur->id)
            ->with('success', 'Permintaan retur berhasil diajukan.');
    }
}

