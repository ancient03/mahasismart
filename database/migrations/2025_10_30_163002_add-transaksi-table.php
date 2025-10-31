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
        // Tabel ini menyimpan info PESANAN (induk)
        Schema::create('transaksi', function (Blueprint $table) {
            // 1. Primary Key
            $table->increments('id_transaksi'); // PK untuk tabel transaksi

            // 2. Foreign Key ke User (Pembeli)
            $table->unsignedInteger('id_user'); 

            // 3. Foreign Key ke Alamat (Alamat Pengiriman)
            // Disimpan di sini agar riwayat alamat tidak berubah jika user update alamat
            $table->unsignedInteger('id_alamat'); 

            // 4. Info Transaksi
            $table->string('nomor_invoice')->unique(); // Nomor unik untuk pesanan
            $table->integer('total_harga_keseluruhan')->unsigned(); // Total harga keseluruhan pesanan
            $table->string('status_pembayaran')->default('pending'); // Misal: pending, paid, failed
            $table->string('status_pengiriman')->default('diproses'); // Misal: diproses, dikirim, selesai, batal
            
            // 5. Kolom tanggal_transaksi diambil dari timestamps()
            $table->timestamps(); // created_at (sebagai tanggal_transaksi) dan updated_at

            // 6. Definisi Foreign Key Constraints
            // Relasi ke tabel users
            $table->foreign('id_user')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade'); // Jika user dihapus, transaksinya ikut terhapus

            // Relasi ke tabel alamat
            $table->foreign('id_alamat')
                  ->references('id_alamat')->on('alamat')
                  ->onDelete('restrict'); // Jangan hapus alamat jika masih tercatat di transaksi
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};

