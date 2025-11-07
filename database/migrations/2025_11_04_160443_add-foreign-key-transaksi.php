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
        Schema::table('transaksi', function (Blueprint $table) {
            // 1. Tambahkan kolom foreign key baru
            // Kolom ini akan menyimpan ID dari tabel 'metode_pembayaran' (misal: 1 untuk "COD")
            // Kita buat 'nullable' agar bisa 'onDelete('set null')'
            $table->unsignedInteger('id_metode_pembayaran')->nullable()->after('total_harga_keseluruhan');

            // 2. Definisikan relasinya (Foreign Key)
            $table->foreign('id_metode_pembayaran')
                  ->references('id_metode_pembayaran')->on('metode_pembayaran') // Merujuk ke tabel 'metode_pembayaran'
                  ->onDelete('set null'); // Jika metode pembayaran (misal: "BCA") dihapus,
                                          // data transaksi lama tetap ada, tapi kolom ini jadi NULL.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi', function (Blueprint $table) {
            // Hapus foreign key dulu (nama constraint default: transaksi_id_metode_pembayaran_foreign)
            $table->dropForeign(['id_metode_pembayaran']); 
            // Hapus kolomnya
            $table->dropColumn('id_metode_pembayaran');
        });
    }
};

