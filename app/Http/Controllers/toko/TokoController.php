<?php

namespace App\Http\Controllers\toko;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Toko;

class TokoController extends Controller
{
    public function create()
    {
            // Cek apakah user yang login SUDAH punya toko
        if (Auth::user()->toko()->exists()) {
            // Jika sudah punya, redirect ke halaman dashboard toko (misalnya)
            // atau kembali ke profile dengan pesan error
            // Ganti 'toko.dashboard' dengan nama rute halaman toko Anda nanti
            // return redirect()->route('toko.dashboard')->with('info', 'Anda sudah memiliki toko.');
            return redirect()->route('profile')->with('error', 'Anda sudah terdaftar memiliki toko.');
        }

        // Jika belum punya toko, tampilkan form create
        return view('page.toko.create'); // Kita akan buat file ini
    }

    public function store(Request $request)
    {
        // Cek lagi (keamanan) apakah user sudah punya toko sebelum menyimpan
        if (Auth::user()->toko()->exists()) {
             return redirect()->route('profile')->with('error', 'Anda sudah terdaftar memiliki toko.');
        }

        // 1. Validasi Input dari Form
        $validated = $request->validate([
            'nama_toko' => ['required', 'string', 'max:255', 'unique:toko,nama_toko'], // Nama toko harus unik
            'no_hp_toko' => ['nullable', 'string', 'max:20'], // Opsional
            'no_rek' => ['nullable', 'string', 'max:50'],    // Opsional, max:50 (sesuaikan)
        ]);

        // 2. Tambahkan id_user dari user yang sedang login
        $validated['id_user'] = Auth::id();

        // 3. Simpan ke database menggunakan Model Toko
        $newToko = Toko::create($validated);

        // 4. Redirect ke halaman toko yang baru dibuat (misalnya)
        //    atau ke halaman profil dengan pesan sukses
        // Ganti 'toko.show' dengan rute detail toko Anda nanti
        // return redirect()->route('toko.show', $newToko->id_toko)->with('status', 'Toko Anda berhasil dibuat!');
         return redirect()->route('profile')->with('status', 'Selamat! Toko Anda berhasil dibuat.');
    }
}
