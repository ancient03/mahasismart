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
        Schema::create('kategori', function (Blueprint $table) {
            // Kolom Primary Key
            $table->increments('id_kategori'); // int unsigned AUTO_INCREMENT PRIMARY KEY

            // Kolom Lainnya
            $table->string('nama_kategori')->unique(); // Nama kategori sebaiknya unik
            $table->integer('total_produk')->default(0); // Jumlah produk dalam kategori ini, defaultnya 0

            // Tidak perlu timestamps() jika tidak dibutuhkan (created_at, updated_at)
            // $table->timestamps(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};

