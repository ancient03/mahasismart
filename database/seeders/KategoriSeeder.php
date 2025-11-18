<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kategori; // Pastikan Model Kategori sudah dibuat
use Illuminate\Support\Facades\DB;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // 2. Siapkan data kategori
        $data = [
            // --- Kategori Induk (L1) ---
            [
                'id_kategori' => 1,
                'nama_kategori' => 'Makanan & Minuman',
                'gambar' => 'img/fotokategori/makanan.png' // Ganti dengan path gambar Anda
            ],
            [
                'id_kategori' => 2,
                'nama_kategori' => 'Kebutuhan Harian',
                'gambar' => 'img/fotokategori/kos.png'
            ],
            [
                'id_kategori' => 3,
                'nama_kategori' => 'Elektronik',
                'gambar' => 'img/fotokategori/elektronik.png'
            ],
            [
                'id_kategori' => 4,
                'nama_kategori' => 'Fashion',
                'gambar' => 'img/fotokategori/fashion.png'
            ],
            [
                'id_kategori' => 5,
                'nama_kategori' => 'Jasa & Layanan',
                'gambar' => 'img/fotokategori/jasa.png'
            ],


        ];

        // 3. Masukkan data ke database menggunakan upsert
        // (Update jika ID sudah ada, Insert jika belum ada)
        Kategori::upsert(
            $data,
            ['id_kategori'], // Kolom unik untuk dicek
            ['nama_kategori', 'gambar'] // Kolom yang di-update jika ID cocok
        );
    }
}