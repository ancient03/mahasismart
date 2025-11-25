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
    Schema::create('foto_ulasan', function (Blueprint $table) {
        $table->increments('id_foto_ulasan');
        $table->unsignedInteger('id_ulasan');
        $table->string('path_foto'); // Lokasi file

        $table->foreign('id_ulasan')->references('id_ulasan')->on('ulasan')->onDelete('cascade');
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('foto_ulasan');
    }
};
