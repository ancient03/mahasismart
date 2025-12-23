<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Transaksi;
use App\Models\Laporan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class LaporanController extends Controller
{
    /**
     * Menampilkan riwayat laporan yang dibuat oleh pembeli.
     */
    public function index(): View
    {
        $user = Auth::user();

        $laporan = Laporan::where('id_user', $user->id_user)
            ->with('transaksi')
            ->latest()
            ->paginate(10);

        return view('page.profile.laporan-saya', compact('laporan'));
    }

    /**
     * Menampilkan form untuk membuat laporan baru.
     */
    public function create($id_transaksi): View|RedirectResponse
    {
        $user = Auth::user();

        // Cari transaksi milik user
        $transaksi = Transaksi::where('id_transaksi', $id_transaksi)
            ->where('id_user', $user->id_user)
            ->whereIn('status_pengiriman', ['dikirim', 'selesai'])
            ->first();

        // Jika transaksi tidak ditemukan atau bukan milik user
        if (!$transaksi) {
            return redirect()->route('pesanan')
                ->with('error', 'Transaksi tidak ditemukan atau tidak bisa dilaporkan.');
        }

        // Cek apakah sudah pernah melapor
        $sudahLapor = Laporan::where('id_transaksi', $id_transaksi)
            ->where('id_user', $user->id_user)
            ->exists();

        if ($sudahLapor) {
            return redirect()->route('pesanan.show', $id_transaksi)
                ->with('error', 'Anda sudah melaporkan pesanan ini sebelumnya.');
        }

        return view('page.profile.lapor-create', compact('transaksi'));
    }

    /**
     * Menyimpan laporan baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $user = Auth::user();

        // 1. Validasi Input
        $validated = $request->validate([
            'id_transaksi' => ['required', 'integer', 'exists:transaksi,id_transaksi'],
            'jenis_masalah' => ['required', 'string', Rule::in(['barang_rusak', 'tidak_sesuai', 'tidak_sampai', 'lainnya'])],
            'deskripsi' => ['required', 'string', 'min:10'],
            'bukti_foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // Wajib upload foto
        ], [
            'jenis_masalah.required' => 'Pilih jenis masalah yang Anda alami.',
            'deskripsi.min' => 'Mohon jelaskan masalah dengan lebih detail (minimal 10 karakter).',
            'bukti_foto.required' => 'Foto bukti wajib diupload.',
            'bukti_foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // 2. Validasi Kepemilikan Transaksi
        $transaksi = Transaksi::where('id_transaksi', $validated['id_transaksi'])
                              ->where('id_user', $user->id_user)
                              ->first();

        if (!$transaksi) {
            return back()->with('error', 'Transaksi tidak ditemukan atau bukan milik Anda.');
        }

        // 3. Cek apakah sudah pernah lapor (double-check)
        $sudahLapor = Laporan::where('id_transaksi', $validated['id_transaksi'])
            ->where('id_user', $user->id_user)
            ->exists();

        if ($sudahLapor) {
            return back()->with('error', 'Anda sudah melaporkan pesanan ini sebelumnya.');
        }

        // 4. Proses Upload Foto Bukti
        $fotoPath = null;
        if ($request->hasFile('bukti_foto')) {
            $file = $request->file('bukti_foto');
            
            // Ganti karakter pemisah direktori (seperti / atau \) dengan underscore.
            $safeInvoice = preg_replace('/[\/\\\\]/', '_', $transaksi->nomor_invoice);

            // Susun nama file: {invoice}_{timestamp}_laporan.{ekstensi}
            $fileName = $safeInvoice . '_' . time() . '_laporan.' . $file->getClientOriginalExtension();
            
            $path = public_path('img/buktilaporan'); // Folder penyimpanan

            // Buat folder jika belum ada
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true, true);
            }

            try {
                $file->move($path, $fileName);
                $fotoPath = $fileName;
            } catch (\Exception $e) {
                return back()->with('error', 'Gagal mengupload foto bukti.')->withInput();
            }
        }

        // 5. Simpan Laporan ke Database
        Laporan::create([
            'id_user' => $user->id_user,
            'id_transaksi' => $validated['id_transaksi'],
            'jenis_masalah' => $validated['jenis_masalah'],
            'deskripsi' => $validated['deskripsi'],
            'bukti_foto' => $fotoPath,
            'status_laporan' => 'pending', // Status awal
        ]);

        // 6. Redirect dengan pesan sukses
        return redirect()->route('laporan.index')
            ->with('status', 'Laporan Anda berhasil dikirim. Admin akan segera meninjaunya.');
    }
}