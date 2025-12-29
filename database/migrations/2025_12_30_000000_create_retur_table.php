<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('retur', function (Blueprint $table) {
        $table->id();

        // 1. Ganti foreignId dengan unsignedInteger (agar cocok dengan tipe data Integer)
        // Jika masih error, coba ganti 'unsignedInteger' menjadi 'integer' (tanpa unsigned)
        $table->unsignedInteger('detail_transaksi_id'); 
        
        // 2. Definisikan Foreign Key secara manual
        $table->foreign('detail_transaksi_id')
              ->references('id_detail_transaksi')
              ->on('detail_transaksi')
              ->onDelete('cascade');

        $table->string('alasan');
        $table->text('catatan')->nullable();
        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('retur');
    }
};