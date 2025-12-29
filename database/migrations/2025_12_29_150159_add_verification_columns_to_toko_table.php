<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('toko', function (Blueprint $table) {
            // Cek dulu apakah kolom sudah ada atau belum
            if (!Schema::hasColumn('toko', 'nama_lengkap')) {
                $table->string('nama_lengkap')->after('logo_toko');
            }
            if (!Schema::hasColumn('toko', 'nik_nim')) {
                $table->string('nik_nim')->after('nama_lengkap');
            }
            if (!Schema::hasColumn('toko', 'foto_verifikasi')) {
                $table->string('foto_verifikasi')->after('nik_nim');
            }
            if (!Schema::hasColumn('toko', 'jenis_verifikasi')) {
                $table->enum('jenis_verifikasi', ['ktp', 'ktm'])->default('ktp')->after('foto_verifikasi');
            }
            if (!Schema::hasColumn('toko', 'is_verified')) {
                $table->boolean('is_verified')->default(false)->after('jenis_verifikasi');
            }
        });
    }

    public function down(): void
    {
        Schema::table('toko', function (Blueprint $table) {
            $table->dropColumn(['nama_lengkap', 'nik_nim', 'foto_verifikasi', 'jenis_verifikasi', 'is_verified']);
        });
    }
};