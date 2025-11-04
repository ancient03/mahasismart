<?php

namespace App\Http\Controllers\toko;

use App\Http\Controllers\Controller;
use App\Models\Barang;
use App\Models\Kategori; 
use App\Models\Toko;    
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\File; 
use Illuminate\Validation\Rule;     
use Illuminate\View\View;          
use Illuminate\Http\RedirectResponse; 
use Illuminate\Support\Facades\Log;     

class BarangController extends Controller
{
    /**
     * Helper: Dapatkan toko milik user.
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
        return $toko; 
    }

     /**
     * Helper function to authorize barang ownership.
     * Memastikan barang yang diakses/diedit/dihapus adalah milik toko user yang login.
     * Aborts with 403 if the barang does not belong to the user's toko.
     */
    private function authorizeBarangOwner(Barang $barang): void
    {
        $userTokoId = Auth::user()->toko?->id_toko;

        // Jika ID toko barang tidak sama dengan ID toko user, hentikan proses
        if ($barang->id_toko !== $userTokoId) { 
            // 403 Forbidden - User tidak punya izin mengakses barang ini
            abort(403, 'Anda tidak diizinkan mengakses barang ini.');
        }
    }


    /**
     * Menampilkan daftar produk.
     */
    public function index(): View
    {
        $toko = $this->getUserToko();
        
        // 2. Ambil semua barang dari toko tersebut
        //    'with('kategori')' => Eager loading untuk mengambil data kategori terkait (lebih efisien)
        //    'orderBy('nama_barang')' => Urutkan berdasarkan nama
        $barangList = $toko->barang()->with('kategori')->orderBy('nama_barang')->get(); 

        // 3. Tampilkan view daftar produk, kirim data barang dan toko
        //    Pastikan path view ini benar: 'resources/views/page/toko/produk-saya.blade.php'
        return view('page.toko.produk-saya', [ 
            'barangList' => $barangList,
            'toko' => $toko 
        ]);
    }

    /**
     * Menampilkan form tambah produk.
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
            'kategoriList' => $kategoriList 
        ]);
    }

    /**
     * Menyimpan produk baru.
     */
    public function store(Request $request): RedirectResponse
    {
        $toko = $this->getUserToko();

        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'id_kategori' => ['required', 'integer', 'exists:kategori,id_kategori'], // Pastikan id_kategori ada di tabel kategori
            'harga' => ['required', 'integer', 'min:0'], // Harga tidak boleh negatif
            'foto_barang' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // Foto opsional, maks 2MB
        ], [
            // Pesan error custom (opsional, bisa diterjemahkan ke Bahasa Indonesia)
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'harga.required' => 'Harga wajib diisi.',
            'foto_barang.*' => 'Foto tidak valid (JPG/PNG/WEBP, maks 2MB).',
        ]);

        $storeData = [
            'id_toko' => $toko->id_toko, // Hubungkan barang ini ke toko user
            'nama_barang' => $validated['nama_barang'],
            'id_kategori' => $validated['id_kategori'],
            'harga' => $validated['harga'],
            'deskripsi' => $validated['deskripsi'] ?? null, 
        ];

        if ($request->hasFile('foto_barang')) {
            $file = $request->file('foto_barang');
            $fileName = time() . '_' . str_replace(' ', '_', $validated['nama_barang']) . '_' . $toko->id_toko . '.' . $file->getClientOriginalExtension();
            $path = public_path('img/fotobarang'); // Folder tujuan (pastikan ada & writable)

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true, true);
            }

            try {
                $file->move($path, $fileName);
                $storeData['foto_barang'] = $fileName; // Simpan nama file ke array data
            } catch (\Exception $e) {
                // Jika gagal, log error dan kembali ke form dengan pesan error
                Log::error('Gagal upload foto barang: ' . $e->getMessage()); 
                return back()->withErrors(['foto_barang' => 'Gagal mengupload foto. Periksa permission folder.'])->withInput();
            }
        }

        // 5. Simpan data barang baru ke database
        Barang::create($storeData);

        // 6. Redirect ke halaman daftar barang dengan pesan sukses
        return redirect()->route('produk-saya.index')->with('status', 'Barang baru berhasil ditambahkan!');
    }


    /**
     * Menampilkan form edit produk.
     * Nama parameter diubah menjadi $produk_saya
     */
    public function edit(Barang $produk_saya): View
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
     * Memperbarui produk.
     * Nama parameter diubah menjadi $produk_saya
     */
    public function update(Request $request, Barang $barang): RedirectResponse
    {
        // 1. Pastikan user adalah pemilik barang ini
        //$this->authorizeBarangOwner($barang); 

        // 2. Validasi data dari form edit
        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'id_kategori' => ['required', 'integer', 'exists:kategori,id_kategori'],
            'harga' => ['required', 'integer', 'min:0'],
            'foto_barang' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // Foto baru (opsional)
            'hapus_foto_barang' => ['nullable', 'boolean'], // Checkbox untuk hapus foto lama
        ], [
            // Pesan error custom (opsional)
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

        // 3. Siapkan data untuk diupdate
        $updateData = [
            'nama_barang' => $validated['nama_barang'],
            'id_kategori' => $validated['id_kategori'],
            'harga' => $validated['harga'],
        ];

        $path = public_path('img/fotobarang'); // Folder foto

        // 4. Proses Upload Foto Barang (jika ada file baru)
        if ($request->hasFile('foto_barang')) {
            $file = $request->file('foto_barang');
            // Buat nama unik baru
            $fileName = time() . '_' . str_replace(' ', '_', $validated['nama_barang']) . '_' . $barang->id_toko . '.' . $file->getClientOriginalExtension();

            // Hapus foto lama jika ada sebelum menyimpan yang baru
            if ($barang->foto_barang) {
                $oldFilePath = $path . '/' . $barang->foto_barang;
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath);
                }
            }

            // Buat folder jika belum ada
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true, true);
            }
            try {
                // Pindahkan file baru
                $file->move($path, $fileName);
                $updateData['foto_barang'] = $fileName; // Simpan nama file baru
            } catch (\Exception $e) {
                Log::error('Gagal update foto barang: ' . $e->getMessage()); 
                return back()->withErrors(['foto_barang' => 'Gagal mengupload foto baru. Periksa permission folder.'])->withInput();
            }
        } elseif ($request->boolean('hapus_foto_barang')) { 
            // 5. Atau, cek jika user ingin menghapus foto yang sudah ada
             if ($barang->foto_barang) {
                $oldFilePath = $path . '/' . $barang->foto_barang;
                if (File::exists($oldFilePath)) {
                    File::delete($oldFilePath); // Hapus file fisik
                }
                $updateData['foto_barang'] = null; // Set null di database
            }
        }
        // Jika tidak ada file baru DAN tidak dicentang hapus, $updateData['foto_barang'] tidak di-set, 
        // sehingga foto lama tidak berubah.

        // 6. Update data barang di database
        $barang->update($updateData);

        // 7. Redirect ke halaman daftar barang
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

        // Hapus file foto jika ada
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
