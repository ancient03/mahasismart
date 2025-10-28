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
        // Perintah untuk MENAMBAH kolom baru
        Schema::table('barang', function (Blueprint $table) {
            $table->string('foto_barang')  // Tipe data VARCHAR (string)
                  ->nullable()           // Boleh kosong (nullable)
                  ->after('harga');       // Diletakkan setelah kolom 'harga' (opsional)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Perintah untuk MENGHAPUS kolom (jika rollback)
        Schema::table('barang', function (Blueprint $table) {
            $table->dropColumn('foto_barang');
        });
    }
};