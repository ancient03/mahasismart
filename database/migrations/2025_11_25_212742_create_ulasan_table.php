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
    Schema::create('ulasan', function (Blueprint $table) {
        $table->increments('id_ulasan');
        $table->unsignedInteger('id_user');      // Siapa yang review
        $table->unsignedInteger('id_barang');    // Barang apa
        $table->unsignedInteger('id_transaksi'); // Transaksi mana (untuk validasi verified purchase)
        
        $table->integer('rating'); // 1 sampai 5
        $table->text('komentar')->nullable();
        
        $table->timestamps();

        // Foreign Keys
        $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        $table->foreign('id_barang')->references('id_barang')->on('barang')->onDelete('cascade');
        $table->foreign('id_transaksi')->references('id_transaksi')->on('transaksi')->onDelete('cascade');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasan');
    }
};
