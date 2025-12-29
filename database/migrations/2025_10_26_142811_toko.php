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
        Schema::create('toko', function (Blueprint $table) {
            // Kolom Primary Key
            $table->increments('id_toko');

            // Kolom Foreign Key ke tabel users
            $table->unsignedInteger('id_user');

            // Kolom Data Toko
            $table->string('nama_toko');
            $table->string('no_hp_toko')->nullable();
            $table->string('no_rek')->nullable();
            $table->string('logo_toko')->nullable();
            
            // Kolom Verifikasi KTP/KTM (BARU)
            $table->string('nama_lengkap');
            $table->string('nik_nim'); // Menyimpan NIK atau NIM (terenkripsi)
            $table->string('foto_verifikasi'); // Path foto KTP/KTM (terenkripsi)
            $table->enum('jenis_verifikasi', ['ktp', 'ktm'])->default('ktp'); // Jenis dokumen
            $table->boolean('is_verified')->default(false); // Status verifikasi
            
            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('id_user')
                  ->references('id_user')->on('users')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('toko');
    }
};