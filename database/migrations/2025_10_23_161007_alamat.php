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
            $table->increments('id_alamat');
            $table->unsignedInteger('id_user');

            $table->string('label'); // Misal: "Rumah", "Kantor", "Apartemen"
            $table->string('nama_penerima');
            $table->string('no_hp_penerima');
            $table->string('provinsi');
            $table->string('province_id')->nullable();
            $table->string('kota');
            $table->string('city_id')->nullable();
            $table->string('kecamatan');
            $table->string('district_id')->nullable();
            $table->string('desa'); // TAMBAHAN KOLOM BARU
            $table->string('kode_pos', 10);
            $table->text('detail_alamat'); // Untuk nama jalan, nomor rumah, RT/RW, dll.
            $table->boolean('is_default')->default(false);

            $table->timestamps();

            $table->foreign('id_user')
                ->references('id_user')
                ->on('users')
                ->onDelete('cascade');
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
