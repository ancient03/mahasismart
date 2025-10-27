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
        Schema::create('barang', function (Blueprint $table) {
            // Kolom Primary Key
            $table->increments('id_barang'); // int unsigned AUTO_INCREMENT PRIMARY KEY

            // Kolom Foreign Key ke tabel toko
            $table->unsignedInteger('id_toko'); 

            // Kolom Foreign Key ke tabel kategori (ASUMSI)
            // Jika tabel kategori Anda punya PK berbeda, sesuaikan 'id_kategori'
            $table->unsignedInteger('id_kategori'); // ASUMSI nama kolom dan tabel referensi

            // Kolom Lainnya
            $table->string('nama_barang');
            $table->integer('harga'); // Tipe data integer untuk harga

            $table->timestamps(); // created_at dan updated_at

            // Definisi Foreign Key Constraint ke toko
            $table->foreign('id_toko')
                  ->references('id_toko')->on('toko') // Merujuk ke id_toko di tabel toko
                  ->onDelete('cascade'); // Jika toko dihapus, barangnya ikut terhapus

            // Definisi Foreign Key Constraint ke kategori (ASUMSI)
            // Jika tabel kategori Anda bernama lain, ganti 'kategori'
            $table->foreign('id_kategori')
                   ->references('id_kategori')->on('kategori') // Merujuk ke id_kategori di tabel kategori
                   ->onDelete('restrict'); // Contoh: Jangan hapus kategori jika masih ada barang terkait
                   // ->onDelete('set null'); // Atau: Set id_kategori jadi NULL jika kategori dihapus (kolom id_kategori harus nullable())
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barang');
    }
};