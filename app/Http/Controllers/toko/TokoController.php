<?php

// 1. Namespace sesuai lokasi file baru
namespace App\Http\Controllers\toko; 

// 2. Import class yang dibutuhkan
use App\Http\Controllers\Controller; // Import Controller utama
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Toko;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse; // <-- Tambahkan ini
use Illuminate\Validation\Rule;      // <-- Tambahkan ini
use Illuminate\Support\Facades\File; // <-- Tambahkan ini
use Illuminate\Support\Facades\DB;

<<<<<<< HEAD
=======
use App\Models\Kategori;
use App\Models\Barang;

>>>>>>> 6a1b16350758c633bc8c49039f49731dfe82a1c7
// 3. Nama class dan extends Controller
class TokoController extends Controller 
{
    public function dashboard(): View
    {
        $user = Auth::user();
        $toko = $user->toko;

        if (!$toko) {
            return redirect()->route('profile')->with('error', 'Anda belum memiliki toko.');
        }

        // 1. Ringkasan Data (Counter Sederhana)
        $totalProduk = $toko->barang()->count();
        
        // Hitung pesanan yang perlu diproses (status 'diproses')
        $pesananPerluDikirim = $toko->detailTransaksi()
            ->whereHas('transaksi', function($q) {
                $q->where('status_pengiriman', 'diproses');
            })->count();

        // Hitung total pendapatan (hanya yang selesai)
        $totalPendapatan = $toko->detailTransaksi()
            ->whereHas('transaksi', function($q) {
                $q->where('status_pengiriman', 'selesai');
            })
            ->sum(DB::raw('kuantitas * harga_saat_transaksi'));

        // 2. Ambil 5 Pesanan Terbaru (untuk tabel 'Pesanan Terbaru')
        $pesananTerbaru = $toko->detailTransaksi()
            ->with(['barang', 'transaksi.user'])
            ->latest('id_detail_transaksi')
            ->take(5)
            ->get();

        return view('page.toko.dashboard', compact(
            'toko', 
            'totalProduk', 
            'pesananPerluDikirim', 
            'totalPendapatan', 
            'pesananTerbaru'
        ));
    }

    /**
     * Menampilkan halaman profil toko milik pengguna yang login.
     */
    public function showProfile(): View
    {
        $user = Auth::user();
        $toko = $user->toko()->firstOrFail(); 
        return view('page.toko.profil-toko', [
            'toko' => $toko 
        ]);
    }

    /**
     * Menampilkan form untuk mengedit data toko.
     * Menggunakan Route Model Binding ($toko).
     */
    public function edit(Barang $produk_saya): View
    {
        // Pastikan user hanya bisa mengedit tokonya sendiri
        if ($toko->id_user !== Auth::id()) {
            abort(403, 'Akses ditolak.'); 
        }

        // Arahkan ke view form edit (buat file ini nanti)
        // Pastikan path view 'page.toko.edit' sudah benar
        return view('page.toko.produk-saya-edit', [
            'toko' => $toko
        ]);
    }

    /**
     * Memperbarui data toko di database.
     * Menggunakan Route Model Binding ($toko).
     */
    public function update(Request $request, Toko $toko): RedirectResponse
    {
        // Pastikan user hanya bisa mengupdate tokonya sendiri
        if ($toko->id_user !== Auth::id()) {
            abort(403, 'Akses ditolak.');
        }

        // 1. Validasi Input 
        $validated = $request->validate([
<<<<<<< HEAD
            // Nama toko harus unik, KECUALI untuk ID toko ini sendiri
=======
>>>>>>> 6a1b16350758c633bc8c49039f49731dfe82a1c7
            'nama_toko' => [
                'required', 'string', 'max:255', 
                Rule::unique('toko', 'nama_toko')->ignore($toko->id_toko, 'id_toko')
            ],
            'no_hp_toko' => ['required', 'string', 'max:20'], 
<<<<<<< HEAD
            'no_rek' => ['nullable', 'string', 'max:50'], // Tambahkan jika perlu
            'logo_toko' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // Logo opsional
        ], [
            // Pesan error kustom (opsional)
=======
            'no_rek' => ['nullable', 'string', 'max:50'],
            'logo_toko' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'banner_toko' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // Validasi banner
        ], [
>>>>>>> 6a1b16350758c633bc8c49039f49731dfe82a1c7
            'nama_toko.required' => 'Nama toko wajib diisi.',
            'nama_toko.unique' => 'Nama toko ini sudah digunakan.',
            'no_hp_toko.required' => 'Nomor handphone toko wajib diisi.',
            'logo_toko.*' => 'Logo tidak valid (JPG/PNG/WEBP, maks 2MB).',
<<<<<<< HEAD
        ]);

        // 2. Siapkan data update (data teks)
        $updateData = [
            'nama_toko' => $validated['nama_toko'],
            'no_hp_toko' => $validated['no_hp_toko'],
            'no_rek' => $validated['no_rek'] ?? $toko->no_rek, // Gunakan no rek lama jika tidak diisi
=======
            'banner_toko.*' => 'Banner tidak valid (JPG/PNG/WEBP, maks 2MB).',
        ]);

        // 2. Siapkan data update
        $updateData = [
            'nama_toko' => $validated['nama_toko'],
            'no_hp_toko' => $validated['no_hp_toko'],
            'no_rek' => $validated['no_rek'] ?? $toko->no_rek,
>>>>>>> 6a1b16350758c633bc8c49039f49731dfe82a1c7
        ];

        // 3. Proses Upload Logo Baru (jika ada)
        if ($request->hasFile('logo_toko')) {
            $file = $request->file('logo_toko');
<<<<<<< HEAD
            $fileName = time() . '_' . str_replace(' ', '_', $validated['nama_toko']) . '.' . $file->getClientOriginalExtension();
            $path = public_path('img/logotoko');

            // Hapus logo lama jika ada
            if ($toko->logo_toko) {
                $oldFilePath = $path . '/' . $toko->logo_toko;
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

             // Buat folder jika belum ada
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true, true);
            }

            // Pindahkan logo baru
            try {
                $file->move($path, $fileName);
                $updateData['logo_toko'] = $fileName; // Simpan nama file baru
            } catch (\Exception $e) {
                return back()->withErrors(['logo_toko' => 'Gagal mengupload logo baru. Periksa permission folder.'])->withInput();
            }
        } 
        // Jika tidak ada logo baru diupload, $updateData['logo_toko'] tidak akan di-set,
        // sehingga nama logo lama di database tidak akan tertimpa.

        // 4. Update data toko di database
        $toko->update($updateData);

        // 5. Redirect kembali ke profil toko dengan pesan sukses
        // Anda bisa redirect ke route('profil-toko') atau route lain yang sesuai
=======
            $fileName = 'logo_' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('img/logotoko');

            if ($toko->logo_toko) {
                File::delete($path . '/' . $toko->logo_toko);
            }

            if (!File::isDirectory($path)) File::makeDirectory($path, 0775, true, true);
            
            $file->move($path, $fileName);
            $updateData['logo_toko'] = $fileName;
        }

        // 4. Proses Upload Banner Baru (jika ada)
        if ($request->hasFile('banner_toko')) {
            $file = $request->file('banner_toko');
            $fileName = 'banner_' . time() . '.' . $file->getClientOriginalExtension();
            $path = public_path('img/bannertoko');

            if ($toko->banner_toko) {
                File::delete($path . '/' . $toko->banner_toko);
            }
            
            if (!File::isDirectory($path)) File::makeDirectory($path, 0775, true, true);

            $file->move($path, $fileName);
            $updateData['banner_toko'] = $fileName;
        }

        // 5. Update data toko di database
        $toko->update($updateData);

        // 6. Redirect kembali dengan pesan sukses
>>>>>>> 6a1b16350758c633bc8c49039f49731dfe82a1c7
        return redirect()->route('profil-toko')->with('status', 'Profil toko berhasil diperbarui!');
    }

    public function statistik(): View
    {
        $user = Auth::user();
        $toko = $user->toko;

        if (!$toko) {
            return redirect()->route('profile')->with('error', 'Anda belum memiliki toko.');
        }

        // Hitung Statistik Sederhana
        // 1. Total Pendapatan (dari pesanan selesai)
        $totalPendapatan = $toko->detailTransaksi()
            ->whereHas('transaksi', function($q) {
                $q->where('status_pengiriman', 'selesai');
            })
            ->sum(DB::raw('kuantitas * harga_saat_transaksi'));

        // 2. Total Pesanan Masuk
        // (Menghitung jumlah detail transaksi unik atau transaksi unik)
        $totalPesanan = $toko->detailTransaksi()->count();

        // 3. Pesanan Per Status
        $pesananDiproses = $toko->detailTransaksi()
            ->whereHas('transaksi', function($q) { $q->where('status_pengiriman', 'diproses'); })
            ->count();
            
        $pesananDikirim = $toko->detailTransaksi()
            ->whereHas('transaksi', function($q) { $q->where('status_pengiriman', 'dikirim'); })
            ->count();

        $pesananSelesai = $toko->detailTransaksi()
            ->whereHas('transaksi', function($q) { $q->where('status_pengiriman', 'selesai'); })
            ->count();

<<<<<<< HEAD
        return view('page.toko.statistik-penjualan', compact(
            'toko', 'totalPendapatan', 'totalPesanan', 'pesananDiproses', 'pesananDikirim', 'pesananSelesai'
        ));
    }
=======
        // --- DATA BARU UNTUK GRAFIK ---
        $salesData = $toko->detailTransaksi()
            ->whereHas('transaksi', function ($query) {
                $query->where('status_pengiriman', 'selesai');
            })
            ->join('transaksi', 'detail_transaksi.id_transaksi', '=', 'transaksi.id_transaksi')
            ->select(
                DB::raw('YEAR(transaksi.created_at) as year'),
                DB::raw('MONTH(transaksi.created_at) as month'),
                DB::raw('SUM(detail_transaksi.kuantitas) as total_kuantitas')
            )
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();

        $chartLabels = $salesData->map(function ($item) {
            return date('F Y', mktime(0, 0, 0, $item->month, 1, $item->year));
        });

        $chartData = $salesData->pluck('total_kuantitas');


        return view('page.toko.statistik-penjualan', compact(
            'toko', 'totalPendapatan', 'totalPesanan', 'pesananDiproses', 'pesananDikirim', 'pesananSelesai',
            'chartLabels', 'chartData'
        ));
    }

    /**
     * Menampilkan halaman publik sebuah toko beserta produknya.
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

>>>>>>> 6a1b16350758c633bc8c49039f49731dfe82a1c7
}