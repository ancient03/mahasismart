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

// 3. Nama class dan extends Controller
class TokoController extends Controller 
{
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
            // Nama toko harus unik, KECUALI untuk ID toko ini sendiri
            'nama_toko' => [
                'required', 'string', 'max:255', 
                Rule::unique('toko', 'nama_toko')->ignore($toko->id_toko, 'id_toko')
            ],
            'no_hp_toko' => ['required', 'string', 'max:20'], 
            'no_rek' => ['nullable', 'string', 'max:50'], // Tambahkan jika perlu
            'logo_toko' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'], // Logo opsional
        ], [
            // Pesan error kustom (opsional)
            'nama_toko.required' => 'Nama toko wajib diisi.',
            'nama_toko.unique' => 'Nama toko ini sudah digunakan.',
            'no_hp_toko.required' => 'Nomor handphone toko wajib diisi.',
            'logo_toko.*' => 'Logo tidak valid (JPG/PNG/WEBP, maks 2MB).',
        ]);

        // 2. Siapkan data update (data teks)
        $updateData = [
            'nama_toko' => $validated['nama_toko'],
            'no_hp_toko' => $validated['no_hp_toko'],
            'no_rek' => $validated['no_rek'] ?? $toko->no_rek, // Gunakan no rek lama jika tidak diisi
        ];

        // 3. Proses Upload Logo Baru (jika ada)
        if ($request->hasFile('logo_toko')) {
            $file = $request->file('logo_toko');
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
        return redirect()->route('profil-toko')->with('status', 'Profil toko berhasil diperbarui!');
    }

}