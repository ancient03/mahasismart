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
        Schema::create('iklan', function (Blueprint $table) {
            $table->id();
            $table->string('nama_iklan');
            $table->string('slogan')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('gambar')->nullable();
            $table->dateTime('dimulai'); // tanggal, bulan, tahun, jam, menit, detik
            $table->dateTime('berakhir');
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('iklan');
    }
};
