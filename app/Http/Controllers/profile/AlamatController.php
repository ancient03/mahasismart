<?php

namespace App\Http\Controllers\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Alamat; // Pastikan Model Alamat ada dan benar
use Illuminate\Validation\Rule; // Untuk validasi unique saat update

class AlamatController extends Controller
{
    /**
     * Menampilkan daftar alamat milik pengguna yang sedang login.
     */
    public function index()
    {
        // Ambil hanya alamat milik user yang login, urutkan berdasarkan is_default
        $alamatList = Auth::user()->alamat()->orderByDesc('is_default')->get();

        return view('page.profile.alamat', [
            'alamatList' => $alamatList
        ]);
    }

    /**
     * Menampilkan form untuk membuat alamat baru.
     */
/**
     * Menampilkan form untuk membuat alamat baru.
     */
    public function create()
    {
        // HARUSNYA HANYA BARIS INI:
        return view('page.profile.alamat-create'); 
    }

    /**
     * Menyimpan alamat baru ke database.
     */
    public function store(Request $request)
    {
        // Validasi Input
        $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'nama_penerima' => ['required', 'string', 'max:255'],
            'no_hp_penerima' => ['required', 'string', 'max:20'],
            'provinsi' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kode_pos' => ['required', 'string', 'max:10'],
            'detail_alamat' => ['required', 'string'],
            'is_default' => ['sometimes', 'boolean'],
        ]);

        $validated['id_user'] = Auth::id();
        $validated['is_default'] = $request->has('is_default');

        // Jika alamat baru ini default, nonaktifkan default alamat lain
        if ($validated['is_default']) {
            Auth::user()->alamat()->update(['is_default' => false]);
        }

        Alamat::create($validated);

        return redirect()->route('alamat.index')->with('status', 'Alamat baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form untuk mengedit alamat.
     * Kita menggunakan Route Model Binding (Alamat $alamat)
     * Laravel akan otomatis mencari Alamat berdasarkan ID di URL.
     */
    public function edit(Alamat $alamat)
    {
        // Pastikan user hanya bisa mengedit alamat miliknya sendiri
        if ($alamat->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.'); // Tampilkan error jika bukan miliknya
        }

        return view('page.profile.alamat-edit', [
            'alamat' => $alamat
        ]);
    }

    /**
     * Memperbarui alamat yang sudah ada di database.
     */
    public function update(Request $request, Alamat $alamat)
    {
        // Pastikan user hanya bisa mengupdate alamat miliknya sendiri
        if ($alamat->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Validasi Input (mirip store, tapi unique check diabaikan jika label sama)
         $validated = $request->validate([
            'label' => ['required', 'string', 'max:255'],
            'nama_penerima' => ['required', 'string', 'max:255'],
            'no_hp_penerima' => ['required', 'string', 'max:20'],
            'provinsi' => ['required', 'string', 'max:255'],
            'kota' => ['required', 'string', 'max:255'],
            'kecamatan' => ['required', 'string', 'max:255'],
            'kode_pos' => ['required', 'string', 'max:10'],
            'detail_alamat' => ['required', 'string'],
            'is_default' => ['sometimes', 'boolean'],
        ]);

        $validated['is_default'] = $request->has('is_default');

        // Jika alamat ini jadi default, nonaktifkan default alamat lain
        if ($validated['is_default']) {
            Auth::user()->alamat()->where('id_alamat', '!=', $alamat->id_alamat)->update(['is_default' => false]);
        }

        // Update data alamat
        $alamat->update($validated);

        return redirect()->route('alamat.index')->with('status', 'Alamat berhasil diperbarui!');
    }

    /**
     * Menghapus alamat dari database.
     */
    public function destroy(Alamat $alamat)
    {
        // Pastikan user hanya bisa menghapus alamat miliknya sendiri
        if ($alamat->id_user !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        // Hapus alamat
        $alamat->delete();

        return redirect()->route('alamat.index')->with('status', 'Alamat berhasil dihapus!');
    }
}

