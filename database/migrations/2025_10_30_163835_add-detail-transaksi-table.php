<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Tabel ini menyimpan DAFTAR BARANG di dalam satu pesanan
        Schema::create('detail_transaksi', function (Blueprint $table) {
            // 1. Primary Key
            $table->increments('id_detail_transaksi');
            
            // 2. Foreign Key ke Transaksi (Induk Pesanan)
            $table->unsignedInteger('id_transaksi');

            // 3. Foreign Key ke Barang (Produk yang dibeli)
            $table->unsignedInteger('id_barang');

            // 4. Foreign Key ke Toko (Penjual produk)
            $table->unsignedInteger('id_toko');

            // 5. Detail Item
            $table->integer('kuantitas')->unsigned(); // Jumlah barang yang dibeli
            $table->integer('harga_saat_transaksi')->unsigned(); // Harga produk saat dibeli (snapshot)
            // (Harga di tabel 'barang' bisa berubah, tapi di sini harga historis)

            $table->timestamps();

            // 6. Definisi Foreign Key Constraints
            // Relasi ke tabel transaksi
            $table->foreign('id_transaksi')
                  ->references('id_transaksi')->on('transaksi')
                  ->onDelete('cascade'); // Jika transaksi (induk) dihapus, detailnya ikut terhapus

            // Relasi ke tabel barang
            $table->foreign('id_barang')
                  ->references('id_barang')->on('barang')
                  ->onDelete('restrict'); // Jangan hapus barang jika sudah pernah terjual

            // Relasi ke tabel toko
            $table->foreign('id_toko')
                  ->references('id_toko')->on('toko')
                  ->onDelete('restrict'); // Jangan hapus toko jika sudah punya riwayat penjualan
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detail_transaksi');
    }
};

