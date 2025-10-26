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
            $table->increments('id_toko'); // int unsigned AUTO_INCREMENT PRIMARY KEY

            // Kolom Foreign Key ke tabel users
            $table->unsignedInteger('id_user'); // Harus unsignedInteger agar cocok dengan increments('id_user')

            // Kolom Lainnya
            $table->string('nama_toko');
            $table->string('no_hp_toko')->nullable(); // varchar, boleh kosong
            $table->string('no_rek')->nullable();     // varchar, boleh kosong
            
            $table->timestamps(); // created_at dan updated_at

            // Definisi Foreign Key Constraint
            $table->foreign('id_user')
                  ->references('id_user')->on('users') // Merujuk ke id_user di tabel users
                  ->onDelete('cascade'); // Jika user dihapus, tokonya ikut terhapus
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