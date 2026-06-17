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
                'gambar' => 'https://images.unsplash.com/photo-1504674900247-0877df9cc836?q=80&w=400&auto=format&fit=crop'
            ],
            [
                'id_kategori' => 2,
                'nama_kategori' => 'Kebutuhan Harian',
                'gambar' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?q=80&w=400&auto=format&fit=crop'
            ],
            [
                'id_kategori' => 3,
                'nama_kategori' => 'Elektronik',
                'gambar' => 'https://images.unsplash.com/photo-1498049794561-7780e7231661?q=80&w=400&auto=format&fit=crop'
            ],
            [
                'id_kategori' => 4,
                'nama_kategori' => 'Fashion',
                'gambar' => 'https://images.unsplash.com/photo-1445205170230-053b83016050?q=80&w=400&auto=format&fit=crop'
            ],
            [
                'id_kategori' => 5,
                'nama_kategori' => 'Jasa & Layanan',
                'gambar' => 'https://images.unsplash.com/photo-1521791136064-7986c2920216?q=80&w=400&auto=format&fit=crop'
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