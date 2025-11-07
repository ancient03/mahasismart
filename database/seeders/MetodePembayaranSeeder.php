<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\MetodePembayaran; // Import Model
use Illuminate\Support\Facades\DB; // (Kita tidak perlu DB::table lagi)

class MetodePembayaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // KITA GANTI DARI TRUNCATE KE UPSERT
        
        // Data yang ingin kita masukkan/perbarui
        $data = [
            [
                'id_metode_pembayaran' => 1,
                'nama_metode' => 'Cash on Delivery',
                'kode_metode' => 'COD',
                'deskripsi' => 'Bayar tunai saat barang diterima.',
                'gambar_logo' => null,
                'is_aktif' => true,
            ],
            [
                'id_metode_pembayaran' => 2,
                'nama_metode' => 'Transfer Bank (Virtual Account)',
                'kode_metode' => 'BCA_VA', // (Contoh kode)
                'deskripsi' => 'Bayar melalui Virtual Account.',
                'gambar_logo' => 'img/logo_pembayaran/bca.png', // (Contoh path logo)
                'is_aktif' => false, 
            ],
            [
                'id_metode_pembayaran' => 3,
                'nama_metode' => 'GoPay / E-Wallet',
                'kode_metode' => 'GOPAY', // (Contoh kode)
                'deskripsi' => 'Bayar menggunakan GoPay.',
                'gambar_logo' => 'img/logo_pembayaran/gopay.png', // (Contoh path logo)
                'is_aktif' => false, 
            ]
        ];

        // Perintah Upsert:
        // 1. Data array
        // 2. Kolom unik untuk dicek (id_metode_pembayaran)
        // 3. Kolom yang akan di-update jika ID-nya sudah ada
        MetodePembayaran::upsert(
            $data, 
            ['id_metode_pembayaran'], 
            ['nama_metode', 'kode_metode', 'deskripsi', 'gambar_logo', 'is_aktif']
        );
    }
}
