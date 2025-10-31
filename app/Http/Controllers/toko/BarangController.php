<?php

namespace App\Http\Controllers\toko;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori; // Import Kategori
use App\Models\Toko;    // Import Toko
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Untuk mendapatkan user & toko
use Illuminate\Support\Facades\File; // Untuk hapus file
use Illuminate\Validation\Rule;      // Untuk validasi
use Illuminate\View\View;            // Untuk return type View
use Illuminate\Http\RedirectResponse; // Untuk return type Redirect
use Illuminate\Support\Facades\Log;    // Untuk logging error (opsional)

class BarangController extends Controller
{
    /**
     * Helper function to get the authenticated user's toko.
     * Aborts with 403 if the user does not own a toko.
     * Mengembalikan objek Toko jika ditemukan.
     */
    private function getUserToko(): Toko
    {
        // Mengambil relasi toko dari user yang login
        // first() mengembalikan null jika tidak ada, firstOrFail() akan error 404
        $toko = Auth::user()->toko()->first();

        // Jika user tidak punya toko, hentikan proses
        if (!$toko) {
            // 403 Forbidden - User tidak punya izin (karena tidak punya toko)
            abort(403, 'Anda harus memiliki toko untuk mengakses halaman ini.');
        }
        return $toko; // Kembalikan objek Toko
    }

    /**
     * Helper function to authorize barang ownership.
     * Memastikan barang yang diakses/diedit/dihapus adalah milik toko user yang login.
     * Aborts with 403 if the barang does not belong to the user's toko.
     */
    private function authorizeBarangOwner(Barang $barang): void
    {
        // Ambil ID toko milik user yang login (gunakan nullsafe operator ?.)
        $userTokoId = Auth::user()->toko?->id_toko;

        // Jika ID toko barang tidak sama dengan ID toko user, hentikan proses
        if ($barang->id_toko !== $userTokoId) {
            // 403 Forbidden - User tidak punya izin mengakses barang ini
            abort(403, 'Anda tidak diizinkan mengakses barang ini.');
        }
    }


    /**
     * Menampilkan daftar produk (barang) milik toko pengguna.
     * Method ini dipanggil oleh route GET /barang (barang.index).
     */
    public function index(): View
    {
        // 1. Dapatkan toko milik user yang login (akan error 403 jika tidak punya)
        $toko = $this->getUserToko();

        // 2. Ambil semua barang dari toko tersebut
        //    'with('kategori')' => Eager loading untuk mengambil data kategori terkait (lebih efisien)
        //    'orderBy('nama_barang')' => Urutkan berdasarkan nama
        $barangList = $toko->barang()->with('kategori')->orderBy('nama_barang')->get();

        // 3. Tampilkan view daftar produk, kirim data barang dan toko
        //    Pastikan path view ini benar: 'resources/views/page/toko/produk-saya.blade.php'
        return view('page.toko.produk-saya', [
            'barangList' => $barangList,
            'toko' => $toko // Kirim data toko jika perlu (misal untuk judul halaman)
        ]);
    }

    /**
     * Menampilkan form untuk menambahkan produk baru.
     * Method ini dipanggil oleh route GET /barang/create (barang.create).
     */
    public function create(): View
    {
        // 1. Pastikan user punya toko
        $this->getUserToko();

        // 2. Ambil semua data kategori untuk ditampilkan di dropdown/select form
        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        // 3. Tampilkan view form tambah barang
        //    Pastikan path view ini benar: 'resources/views/page/toko/barang-create.blade.php'
        return view('page.toko.barang-create', [
            'kategoriList' => $kategoriList // Kirim daftar kategori ke view
        ]);
    }

    /**
     * Menyimpan produk baru ke database.
     * Method ini dipanggil oleh route POST /barang (barang.store).
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Dapatkan toko user
        $toko = $this->getUserToko();

        // 2. Validasi data dari form
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'id_kategori' => ['required', 'integer', 'exists:kategori,id_kategori'],
            'harga' => ['required', 'integer', 'min:0'],
            'foto_barang' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'id_kategori.exists' => 'Kategori yang dipilih tidak valid.',
            'harga.required' => 'Harga wajib diisi.',
            'harga.integer' => 'Harga harus berupa angka.',
            'harga.min' => 'Harga tidak boleh negatif.',
            'foto_barang.image' => 'File harus berupa gambar.',
            'foto_barang.mimes' => 'Format gambar harus JPG, JPEG, PNG, atau WEBP.',
            'foto_barang.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        // 3. Siapkan data untuk disimpan ke tabel 'barang'
        $storeData = [
            'id_toko' => $toko->id_toko,
            'nama_barang' => $validated['nama_barang'],
            'id_kategori' => $validated['id_kategori'],
            'harga' => $validated['harga'],
        ];

        // 4. Proses Upload Foto Barang (jika ada)
        if ($request->hasFile('foto_barang')) {
            $file = $request->file('foto_barang');
            $fileName = time() . '_' . str_replace(' ', '_', $validated['nama_barang']) . '_' . $toko->id_toko . '.' . $file->getClientOriginalExtension();
            $path = public_path('img/fotobarang');

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true, true);
            }

            try {
                $file->move($path, $fileName);
                $storeData['foto_barang'] = $fileName;
            } catch (\Exception $e) {
                Log::error('Gagal upload foto barang: ' . $e->getMessage());
                return back()->withErrors(['foto_barang' => 'Gagal mengupload foto. Periksa permission folder.'])->withInput();
            }
        }

        // 5. Simpan data barang baru ke database
        $barang = Barang::create($storeData);

        // ✅ 6. Update total produk kategori
        $kategori = Kategori::find($validated['id_kategori']);
        if ($kategori) {
            $kategori->increment('total_produk'); // Lebih ringkas daripada $kategori->total_produk += 1
        }

        // 7. Redirect ke halaman daftar barang dengan pesan sukses
        return redirect()->route('produk-saya.index')->with('status', 'Barang baru berhasil ditambahkan!');
    }


    /**
     * Display the specified resource. (Tidak digunakan karena kita pakai index)
     */
    public function show(Barang $barang)
    {
        abort(404); // Atau implementasikan halaman detail jika perlu
    }

    /**
     * Menampilkan form untuk mengedit produk.
     * Method ini dipanggil oleh route GET /barang/{barang}/edit (barang.edit).
     * Laravel otomatis mencari $barang berdasarkan ID di URL (Route Model Binding).
     */
    public function edit(Barang $produk_saya): View  //waspada error di class untuk memanggil edit
    {
        // 1. Pastikan user adalah pemilik barang ini
        //    Gunakan variabel baru $produk_saya
        $this->authorizeBarangOwner($produk_saya);

        // 2. Ambil semua kategori untuk dropdown
        $kategoriList = Kategori::orderBy('nama_kategori')->get();

        // 3. Tampilkan view form edit barang
        //    Kirim variabel dengan nama 'barang' agar view lama tetap berfungsi
        //    ATAU ubah variabel di view menjadi $produk_saya
        return view('page.toko.produk-saya-edit', [ // Pastikan nama view benar
            'barang' => $produk_saya, // Kirim dengan nama 'barang' agar view tidak perlu diubah
            'kategoriList' => $kategoriList
        ]);
    }

    /**
     * Memperbarui data produk di database.
     * Method ini dipanggil oleh route PUT/PATCH /barang/{barang} (barang.update).
     */
    public function update(Request $request, $id): RedirectResponse
{
    // 1. Ambil barang dari database
    $barang = Barang::findOrFail($id);

    // 2. Pastikan user adalah pemilik barang ini
    $this->authorizeBarangOwner($barang);

    // 3. Validasi data input
    $validated = $request->validate([
        'nama_barang' => ['required', 'string', 'max:255'],
        'id_kategori' => ['required', 'integer', 'exists:kategori,id_kategori'],
        'harga' => ['required', 'integer', 'min:0'],
        'foto_barang' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        'hapus_foto_barang' => ['nullable', 'boolean'],
    ]);

    // Simpan id kategori lama
    $oldKategoriId = $barang->id_kategori;

    // 4. Data yang akan diupdate
    $updateData = [
        'nama_barang' => $validated['nama_barang'],
        'id_kategori' => $validated['id_kategori'],
        'harga' => $validated['harga'],
    ];

    $path = public_path('img/fotobarang');

    // 5. Jika upload foto baru
    if ($request->hasFile('foto_barang')) {
        $file = $request->file('foto_barang');
        $fileName = time() . '_' . str_replace(' ', '_', $validated['nama_barang']) . '_' . $barang->id_toko . '.' . $file->getClientOriginalExtension();

        // Hapus foto lama
        if ($barang->foto_barang && File::exists($path . '/' . $barang->foto_barang)) {
            File::delete($path . '/' . $barang->foto_barang);
        }

        // Pastikan folder ada
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0775, true, true);
        }

        $file->move($path, $fileName);
        $updateData['foto_barang'] = $fileName;
    } elseif ($request->boolean('hapus_foto_barang')) {
        if ($barang->foto_barang && File::exists($path . '/' . $barang->foto_barang)) {
            File::delete($path . '/' . $barang->foto_barang);
        }
        $updateData['foto_barang'] = null;
    }

    // 6. Update data barang
    $barang->update($updateData);

    // 7. Jika kategori berubah, update total produk masing-masing kategori
    if ($oldKategoriId != $validated['id_kategori']) {
        // Kurangi 1 di kategori lama
        $oldKategori = Kategori::find($oldKategoriId);
        if ($oldKategori) {
            $oldKategori->decrement('total_produk');
        }

        // Tambah 1 di kategori baru
        $newKategori = Kategori::find($validated['id_kategori']);
        if ($newKategori) {
            $newKategori->increment('total_produk');
        }
    }

    // 8. Redirect
    return redirect()->route('produk-saya.index')->with('status', 'Data barang berhasil diperbarui!');
}


    /**
     * Menghapus produk dari database.
     * Method ini dipanggil oleh route DELETE /barang/{barang} (barang.destroy).
     */
    public function destroy($id): RedirectResponse
    {
        Log::info('Masuk destroy method dengan ID: ' . $id); // Log ID yang diterima

        // 1. Coba cari Barang menggunakan findOrFail()
        try {
            $barang = Barang::findOrFail($id); // Ini akan error 404 jika ID tidak valid
            Log::info('Barang ditemukan via findOrFail. ID: ' . $barang->id_barang . ', Nama: ' . $barang->nama_barang);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            Log::error('Barang dengan ID ' . $id . ' tidak ditemukan saat destroy.');
            // Kembali ke halaman sebelumnya atau index dengan error
            return back()->with('error', 'Barang yang ingin dihapus tidak ditemukan.');
        } catch (\Exception $e) {
            // Error lain saat mencari barang
            Log::error('Error saat mencari barang ID ' . $id . ' untuk dihapus: ' . $e->getMessage());
            return redirect()->route('produk-saya.index')->with('error', 'Terjadi kesalahan saat mencari barang.');
        }

        // 2. Otorisasi (Pastikan user pemilik barang)
        //    Kita uncomment lagi untuk keamanan
        try {
            $this->authorizeBarangOwner($barang);
        } catch (\Symfony\Component\HttpKernel\Exception\HttpException $e) {
            Log::warning('Upaya menghapus barang oleh user yang tidak berhak. Barang ID: ' . $barang->id_barang . ', User ID: ' . Auth::id());
            return redirect()->route('produk-saya.index')->with('error', 'Anda tidak diizinkan menghapus barang ini.');
        }

        Log::info('Otorisasi berhasil. Mencoba menghapus barang ID: ' . $barang->id_barang . ' - Nama: ' . $barang->nama_barang);

        // 3. Hapus file foto jika ada
        if ($barang->foto_barang) {
            $fotoPath = public_path('img/fotobarang/' . $barang->foto_barang);
            if (File::exists($fotoPath)) {
                try {
                    File::delete($fotoPath);
                    Log::info('File foto barang dihapus: ' . $fotoPath);
                } catch (\Exception $e) {
                    Log::error('Gagal menghapus file foto barang: ' . $e->getMessage());
                }
            } else {
                Log::warning('File foto barang tidak ditemukan untuk dihapus: ' . $fotoPath);
            }
        }

        // 4. Coba Hapus data barang dari database
        $deleted = false;
        try {
            $deleted = $barang->delete();
        } catch (\Exception $e) {
            Log::error('Exception saat menghapus barang ID: ' . $barang->id_barang . ' - Pesan: ' . $e->getMessage());
            return redirect()->route('produk-saya.index')->with('error', 'Terjadi kesalahan saat menghapus barang. Cek log.');
        }

        Log::info('Hasil $barang->delete() untuk barang ID ' . $barang->id_barang . ': ' . ($deleted ? 'BERHASIL (true)' : 'GAGAL (false)'));

        // 5. Redirect berdasarkan hasil delete
        if ($deleted) {
            return redirect()->route('produk-saya.index')->with('status', 'Barang berhasil dihapus!');
        } else {
            Log::error('Gagal menghapus barang ID: ' . $barang->id_barang . ' - delete() mengembalikan false tanpa exception.');
            // Coba tambahkan pesan error lebih spesifik jika ada relasi yang menghalangi
            return redirect()->route('produk-saya.index')->with('error', 'Gagal menghapus barang. Pastikan tidak ada data lain yang terkait.');
        }
    }
}
