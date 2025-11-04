<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Jalankan migrasi
    public function up(): void
    {
        Schema::create('iklan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_iklan');
            $table->string('slogan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->dateTime('dimulai');
            $table->dateTime('berakhir');

            // ✅ Tambahkan kolom status dengan dua opsi: aktif / tidak_aktif
            $table->enum('status', ['aktif', 'tidak_aktif'])->default('tidak_aktif');

            $table->timestamps(); // created_at & updated_at
        });
    }

    // Balik migrasi
    public function down(): void
    {
        Schema::dropIfExists('iklan');
    }
};
