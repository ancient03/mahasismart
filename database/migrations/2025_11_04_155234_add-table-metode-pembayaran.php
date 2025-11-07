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
        // Tabel ini menyimpan daftar metode pembayaran
        Schema::create('metode_pembayaran', function (Blueprint $table) {
            $table->increments('id_metode_pembayaran');
            
            // Nama yang tampil ke user (misal: "Cash on Delivery", "Transfer Bank BCA")
            $table->string('nama_metode'); 
            
            // Kode unik untuk logika di controller (misal: "COD", "BCA_VA")
            $table->string('kode_metode')->unique(); 
            
            // Deskripsi singkat (opsional)
            $table->text('deskripsi')->nullable();
            
            // Kolom untuk gambar/logo metode (misal: logo BCA, GoPay)
            $table->string('gambar_logo')->nullable();

            // Untuk mengaktifkan atau menonaktifkan metode ini
            $table->boolean('is_aktif')->default(true); 
            
            // $table->timestamps(); // Tidak perlu timestamps untuk tabel master ini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('metode_pembayaran');
    }
};

