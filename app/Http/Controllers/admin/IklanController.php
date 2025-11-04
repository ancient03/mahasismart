<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Iklan;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class IklanController extends Controller
{
    // 🔹 Halaman daftar iklan
    public function index()
    {
        // Perbarui otomatis status iklan berdasarkan tanggal saat ini
        $now = Carbon::now();

        Iklan::where('berakhir', '<', $now)
            ->where('status', 'aktif')
            ->update(['status' => 'tidak_aktif']);

        Iklan::where('dimulai', '<=', $now)
            ->where('berakhir', '>=', $now)
            ->where('status', 'tidak_aktif')
            ->update(['status' => 'aktif']);

        // Ambil semua iklan
        $iklan = Iklan::latest()->get();

        return view('page.admin.iklan', compact('iklan'));
    }

    // 🔹 Halaman form tambah iklan
    public function create()
    {
        return view('page.admin.tambah-iklan');
    }

    // 🔹 Proses simpan iklan baru
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_iklan' => 'required|string|max:255',
            'slogan' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'gambar' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'dimulai' => 'required|date',
            'berakhir' => 'required|date|after:dimulai',
        ]);

        // Tentukan status berdasarkan tanggal
        $now = Carbon::now();
        if ($validated['dimulai'] <= $now && $validated['berakhir'] >= $now) {
            $status = 'aktif';
        } else {
            $status = 'tidak_aktif';
        }

        // Simpan gambar
        $path = null;
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/fotoiklan'), $filename);
            $path = 'img/fotoiklan/' . $filename;
        }

        // Simpan ke database
        Iklan::create([
            'nama_iklan' => $validated['nama_iklan'],
            'slogan' => $validated['slogan'],
            'deskripsi' => $validated['deskripsi'],
            'gambar' => $path,
            'dimulai' => $validated['dimulai'],
            'berakhir' => $validated['berakhir'],
            'status' => $status,
        ]);

        return redirect()->route('admin.iklan')->with('success', 'Iklan berhasil ditambahkan!');
    }

    // 🔹 Halaman edit iklan
    public function edit($id)
    {
        $iklan = Iklan::findOrFail($id);
        return view('page.admin.edit-iklan', compact('iklan'));
    }

    // 🔹 Proses update iklan
    public function update(Request $request, $id)
    {
        $iklan = Iklan::findOrFail($id);

        $validated = $request->validate([
            'nama_iklan' => 'required|string|max:255',
            'slogan' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'dimulai' => 'required|date',
            'berakhir' => 'required|date|after:dimulai',
        ]);

        // Tentukan status
        $now = Carbon::now();
        if ($validated['dimulai'] <= $now && $validated['berakhir'] >= $now) {
            $status = 'aktif';
        } else {
            $status = 'tidak_aktif';
        }

        // Gambar baru?
        $path = $iklan->gambar;
        if ($request->hasFile('gambar')) {
            if ($iklan->gambar && file_exists(public_path($iklan->gambar))) {
                unlink(public_path($iklan->gambar));
            }

            $file = $request->file('gambar');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('img/fotoiklan'), $filename);
            $path = 'img/fotoiklan/' . $filename;
        }

        // Update data
        $iklan->update([
            'nama_iklan' => $validated['nama_iklan'],
            'slogan' => $validated['slogan'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'gambar' => $path,
            'dimulai' => $validated['dimulai'],
            'berakhir' => $validated['berakhir'],
            'status' => $status,
        ]);

        return redirect()->route('admin.iklan')->with('success', 'Iklan berhasil diperbarui!');
    }

    // 🔹 Hapus iklan
    public function destroy($id)
    {
        $iklan = Iklan::findOrFail($id);

        if ($iklan->gambar && file_exists(public_path($iklan->gambar))) {
            unlink(public_path($iklan->gambar));
        }

        $iklan->delete();

        return redirect()->route('admin.iklan')->with('success', 'Iklan berhasil dihapus!');
    }
}
