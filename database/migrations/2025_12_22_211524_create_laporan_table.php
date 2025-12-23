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
        Schema::create('laporan', function (Blueprint $table) {
            $table->increments('id_laporan');
            
            // Relasi ke User (Pelapor)
            $table->unsignedInteger('id_user'); 
            
            // Relasi ke Transaksi yang bermasalah (Opsional, bisa juga ke detail_transaksi jika per barang)
            // Di sini kita asumsi lapor per transaksi/pesanan
            $table->unsignedInteger('id_transaksi'); 

            // Jenis Masalah (Dropdown pilihan)
            // Contoh: 'barang_rusak', 'tidak_sesuai', 'tidak_sampai', 'lainnya'
            $table->string('jenis_masalah');

            // Deskripsi detail masalah
            $table->text('deskripsi');

            // Bukti Foto (Path file)
            $table->string('bukti_foto')->nullable();

            // Status Laporan: 'pending', 'diproses', 'selesai', 'ditolak'
            $table->string('status_laporan')->default('pending');
            
            $table->timestamps();

            // Foreign Keys
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
            $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan');
    }
};