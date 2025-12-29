<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use App\Models\Retur;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ReturController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // Mengambil data retur milik user yang sedang login
        $returs = Retur::whereHas('detailTransaksi.transaksi', function ($query) use ($user) {
            $query->where('id_user', $user->id_user); // Pastikan column id user sesuai database (id atau id_user)
        })->with('detailTransaksi.barang')->latest()->get();

        return view('page.profile.retur.index', compact('returs'));
    }

    /**
     * Menampilkan Form Create Retur
     * URL: /profile/retur/create/{id_detail_transaksi}
     */
    public function create($id)
    {
        // Cari detail transaksi
        $detail_transaksi = DetailTransaksi::with(['transaksi', 'barang'])->findOrFail($id);

        // 1. Cek Policy (Apakah user pemilik transaksi & status sudah selesai?)
        // Kita pakai nama method 'create' di Policy, tapi pass object DetailTransaksi
        $response = Gate::inspect('create', [Retur::class, $detail_transaksi]);
    
        if (!$response->allowed()) {
            // Jika policy ReturPolicy logicnya: return $user->id === $detailTransaksi->transaksi->id_user ...
            // Kita bisa cek manual atau pastikan Policy menerima DetailTransaksi sebagai argumen ke-2
             $this->authorize('create', [Retur::class, $detail_transaksi]);
        }

        // 2. Cek apakah barang ini sudah pernah diretur sebelumnya?
        $existingRetur = Retur::where('detail_transaksi_id', $id)->first();
        if ($existingRetur) {
            return redirect()->route('retur.show', $existingRetur->id)
                ->with('error', 'Barang ini sudah diajukan retur sebelumnya.');
        }

        return view('page.profile.retur.create', compact('detail_transaksi'));
    }

    /**
     * Menyimpan Data Retur
     */
    public function store(Request $request)
    {
        // 1. Validasi Input
        $request->validate([
            'detail_transaksi_id' => 'required|exists:detail_transaksi,id_detail_transaksi', // sesuaikan nama primary key
            'alasan' => 'required|string|max:255',
            'catatan' => 'nullable|string',
        ]);

        // 2. Ambil detail transaksi untuk validasi kepemilikan
        $detailTransaksi = DetailTransaksi::with('transaksi')->findOrFail($request->detail_transaksi_id);

        // 3. Cek Otorisasi lagi (Security Layer)
        // Pastikan user yang login adalah pemilik transaksi
        if ($detailTransaksi->transaksi->id_user !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses untuk meretur pesanan ini.');
        }

        // 4. Cek apakah sudah pernah diretur (Double Check)
        if (Retur::where('detail_transaksi_id', $request->detail_transaksi_id)->exists()) {
            return back()->with('error', 'Permintaan retur untuk barang ini sudah ada.');
        }

        // 5. Simpan Retur
        $retur = Retur::create([
            'detail_transaksi_id' => $request->detail_transaksi_id,
            'alasan' => $request->alasan,
            'catatan' => $request->catatan,
            'status' => 'pending',
        ]);

        return redirect()->route('retur.index')->with('success', 'Permintaan retur berhasil dikirim. Menunggu persetujuan admin.');
    }

public function show(Retur $retur)
{
    // Gunakan Gate::authorize
    Gate::authorize('view', $retur); 

    $retur->load('detailTransaksi.transaksi', 'detailTransaksi.barang');
    return view('page.profile.retur.show', compact('retur'));
}
}