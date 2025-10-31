<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    // Menampilkan daftar kategori
    public function index()
    {
        $kategori = Kategori::withCount('barang')->get();
        return view('page.admin.kategori', compact('kategori'));
    }

    // Menampilkan form tambah kategori
    public function create()
    {
        return view('page.admin.tambah-kategori');
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $tujuanPath = public_path('img/fotokategori');
        if (!file_exists($tujuanPath)) mkdir($tujuanPath, 0777, true);

        $namaFile = time() . '_' . $request->file('gambar')->getClientOriginalName();
        $request->file('gambar')->move($tujuanPath, $namaFile);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori,
            'gambar' => 'img/fotokategori/' . $namaFile,
        ]);

        return redirect()->route('admin.kategori')->with('status', 'Kategori berhasil ditambahkan!');
    }

    // Menampilkan form edit kategori
    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        return view('page.admin.edit-kategori', compact('kategori'));
    }


    // Update kategori
    public function update(Request $request, $id)
    {
        $kategori = Kategori::findOrFail($id);

        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        // Jika ada gambar baru
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama
            if ($kategori->gambar && file_exists(public_path($kategori->gambar))) {
                unlink(public_path($kategori->gambar));
            }

            // Simpan gambar baru
            $tujuanPath = public_path('img/fotokategori');
            if (!file_exists($tujuanPath)) mkdir($tujuanPath, 0777, true);

            $namaFile = time() . '_' . $request->file('gambar')->getClientOriginalName();
            $request->file('gambar')->move($tujuanPath, $namaFile);

            $kategori->gambar = 'img/fotokategori/' . $namaFile;
        }

        $kategori->nama_kategori = $request->nama_kategori;
        $kategori->save();

        return redirect()->route('admin.kategori')->with('status', 'Kategori berhasil diperbarui!');
    }
}
