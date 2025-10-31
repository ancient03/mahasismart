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
        Schema::create('keranjang', function (Blueprint $table) {
            // 1. Primary Key untuk tabel keranjang itu sendiri
            $table->increments('id_keranjang');

            // 2. Foreign Key untuk User
            // Harus unsignedInteger agar cocok dengan increments('id_user') di tabel 'users'
            $table->unsignedInteger('id_user');

            // 3. Foreign Key untuk Barang
            // Harus unsignedInteger agar cocok dengan increments('id_barang') di tabel 'barang'
            $table->unsignedInteger('id_barang');

            // 4. Kolom untuk jumlah barang
            $table->integer('kuantitas')->unsigned()->default(1); // Kuantitas (jumlah) barang, minimal 1

            $table->timestamps(); // created_at dan updated_at

            // 5. Definisi Foreign Key Constraints
            
            // Relasi ke tabel users
            $table->foreign('id_user')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade'); // Jika user dihapus, keranjangnya ikut terhapus

            // Relasi ke tabel barang
            $table->foreign('id_barang')
                  ->references('id_barang')->on('barang')
                  ->onDelete('cascade'); // Jika barang dihapus, item ini hilang dari keranjang

            // 6. Constraint Unik
            // Mencegah satu user memiliki dua baris untuk barang yang sama.
            // Jika user menambah barang yang sama, kita hanya perlu update 'kuantitas'.
            $table->unique(['id_user', 'id_barang']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keranjang');
    }
};