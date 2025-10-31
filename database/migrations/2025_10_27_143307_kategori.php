<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Jalankan migration.
     */
    public function up(): void
    {
        Schema::create('kategori', function (Blueprint $table) {
            // Primary Key
            $table->increments('id_kategori');

            // Kolom Lainnya
            $table->string('nama_kategori')->unique(); // Nama kategori unik
            $table->string('gambar'); // Kolom untuk menyimpan path gambar
            $table->integer('total_produk')->default(0); // Jumlah produk dalam kategori

            // Tidak memakai timestamps
            // $table->timestamps();
        });
    }

    /**
     * Rollback migration.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
