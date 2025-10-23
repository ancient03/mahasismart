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
        Schema::create('alamat', function (Blueprint $table) {
            // 1. Primary Key untuk tabel ini
            $table->increments('id_alamat');

            // 2. Foreign Key untuk relasi ke users
            // Kita gunakan unsignedInteger agar tipenya SAMA PERSIS
            // dengan 'id_user' di tabel 'users' (yang dibuat oleh increments())
            $table->unsignedInteger('id_user');

            // 3. Kolom-kolom untuk alamat
            $table->string('label'); // Misal: "Rumah", "Kantor", "Apartemen"
            $table->string('nama_penerima');
            $table->string('no_hp_penerima');
            $table->string('provinsi');
            $table->string('kota');
            $table->string('kecamatan');
            $table->string('kode_pos', 10);
            $table->text('detail_alamat'); // Untuk nama jalan, nomor rumah, RT/RW, dll.
            $table->boolean('is_default')->default(false); // Untuk menandai alamat utama

            $table->timestamps(); // created_at dan updated_at

            // 4. Mendefinisikan constraint (relasinya)
            $table->foreign('id_user')             // Kolom 'id_user' di tabel 'alamat' ini
                  ->references('id_user')          // Merujuk ke kolom 'id_user'
                  ->on('users')                  // Di dalam tabel 'users'
                  ->onDelete('cascade');         // Jika user dihapus, alamatnya ikut terhapus
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat');
    }
};