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
        $toko = Auth::user()->toko()->first(); 
        if (!$toko) {
            abort(403, 'Anda harus memiliki toko untuk mengakses halaman ini.');
        }
        return $toko; 
    }

    /**
     * Helper: Otorisasi kepemilikan barang.
     */
    private function authorizeBarangOwner(Barang $barang): void
    {
        $userTokoId = Auth::user()->toko?->id_toko;
        if ($barang->id_toko !== $userTokoId) { 
            abort(403, 'Anda tidak diizinkan mengakses barang ini.');
        }
    }


    /**
     * Menampilkan daftar produk.
     */
    public function index(): View
    {
        $toko = $this->getUserToko();
        $barangList = $toko->barang()->with('kategori')->orderBy('nama_barang')->get(); 

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
        $this->getUserToko(); 
        $kategoriList = Kategori::orderBy('nama_kategori')->get(); 
        
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
            'id_kategori' => ['required', 'integer', 'exists:kategori,id_kategori'], 
            'harga' => ['required', 'integer', 'min:0'], 
            'deskripsi' => ['nullable', 'string'],
            'foto_barang' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], 
        ], [
            // Pesan error...
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'harga.required' => 'Harga wajib diisi.',
            'foto_barang.*' => 'Foto tidak valid (JPG/PNG/WEBP, maks 2MB).',
        ]);

        $storeData = [
            'id_toko' => $toko->id_toko, 
            'nama_barang' => $validated['nama_barang'],
            'id_kategori' => $validated['id_kategori'],
            'harga' => $validated['harga'],
            'deskripsi' => $validated['deskripsi'] ?? null, 
        ];

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

        Barang::create($storeData);

        return redirect()->route('produk-saya.index')->with('status', 'Barang baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit produk.
     * Nama parameter diubah menjadi $produk_saya
     */
    public function edit(Barang $produk_saya): View
    {
        $this->authorizeBarangOwner($produk_saya); 
        $kategoriList = Kategori::orderBy('nama_kategori')->get(); 
        
        return view('page.toko.produk-saya-edit', [ 
            'barang' => $produk_saya, // Tetap kirim sebagai 'barang' agar view tidak usah diubah
            'kategoriList' => $kategoriList 
        ]);
    }

    /**
     * Memperbarui produk.
     * Nama parameter diubah menjadi $produk_saya
     */
    public function update(Request $request, Barang $produk_saya): RedirectResponse
    {
        $this->authorizeBarangOwner($produk_saya); 

        $validated = $request->validate([
            'nama_barang' => ['required', 'string', 'max:255'],
            'id_kategori' => ['required', 'integer', 'exists:kategori,id_kategori'],
            'harga' => ['required', 'integer', 'min:0'],
            'deskripsi' => ['nullable', 'string'],
            'foto_barang' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], 
            'hapus_foto_barang' => ['nullable', 'boolean'], 
        ], [
            // Pesan error...
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'id_kategori.required' => 'Kategori wajib dipilih.',
            'harga.required' => 'Harga wajib diisi.',
            'foto_barang.*' => 'Foto baru tidak valid (JPG/PNG/WEBP, maks 2MB).',
        ]);

        $updateData = [
            'nama_barang' => $validated['nama_barang'],
            'id_kategori' => $validated['id_kategori'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'harga' => $validated['harga'],
        ];

        $path = public_path('img/fotobarang'); 

        if ($request->hasFile('foto_barang')) {
            $file = $request->file('foto_barang');
            $fileName = time() . '_' . str_replace(' ', '_', $validated['nama_barang']) . '_' . $produk_saya->id_toko . '.' . $file->getClientOriginalExtension();

            // Hapus foto lama
            if ($produk_saya->foto_barang && File::exists($path . '/' . $produk_saya->foto_barang)) {
                File::delete($path . '/' . $produk_saya->foto_barang);
            }
            
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0775, true, true);
            }
            try {
                $file->move($path, $fileName);
                $updateData['foto_barang'] = $fileName; 
            } catch (\Exception $e) {
                Log::error('Gagal update foto barang: ' . $e->getMessage()); 
                return back()->withErrors(['foto_barang' => 'Gagal mengupload foto baru.'])->withInput();
            }
        } elseif ($request->boolean('hapus_foto_barang')) { 
            if ($produk_saya->foto_barang && File::exists($path . '/' . $produk_saya->foto_barang)) {
                 File::delete($path . '/' . $produk_saya->foto_barang); 
            }
            $updateData['foto_barang'] = null; // Set null di database
        }

        $produk_saya->update($updateData);

        return redirect()->route('produk-saya.index')->with('status', 'Data barang berhasil diperbarui!');
    }

    /**
     * Menghapus produk.
     * Nama parameter diubah menjadi $produk_saya
     */
    public function destroy(Barang $produk_saya): RedirectResponse 
    {
        $this->authorizeBarangOwner($produk_saya); 
        Log::info('Otorisasi berhasil. Mencoba menghapus barang ID: ' . $produk_saya->id_barang); 

        // Hapus file foto jika ada
        if ($produk_saya->foto_barang) {
            $fotoPath = public_path('img/fotobarang/' . $produk_saya->foto_barang);
            if (File::exists($fotoPath)) {
                try {
                    File::delete($fotoPath);
                    Log::info('File foto barang dihapus: ' . $fotoPath); 
                } catch (\Exception $e) {
                    Log::error('Gagal menghapus file foto barang: ' . $e->getMessage());
                }
            }
        }

        // Coba Hapus data
        $deleted = false; 
        try {
            $deleted = $produk_saya->delete(); 
        } catch (\Exception $e) {
            // Ini terjadi jika ada foreign key constraint (misal: barang ada di pesanan)
            Log::error('Exception saat menghapus barang ID: ' . $produk_saya->id_barang . ' - Pesan: ' . $e->getMessage());
            // Beri pesan error yang jelas ke user
            return redirect()->route('produk-saya.index')->with('error', 'Gagal menghapus barang. Kemungkinan barang ini sudah ada di dalam pesanan.');
        }

        if ($deleted) {
            return redirect()->route('produk-saya.index')->with('status', 'Barang berhasil dihapus!');
        } else {
            // Ini terjadi jika ada Model Event (deleting) yang return false
            Log::error('Gagal menghapus barang ID: ' . $produk_saya->id_barang . ' - delete() mengembalikan false.'); 
            return redirect()->route('produk-saya.index')->with('error', 'Gagal menghapus barang.');
        }
    }
}
