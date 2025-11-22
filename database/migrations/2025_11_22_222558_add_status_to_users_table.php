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
        Schema::table('users', function (Blueprint $table) {
            // status_user: 'aktif', 'banned'
            $table->string('status_user')->default('aktif')->after('foto_profil');
            // catatan admin: alasan kenapa dibanned
            $table->text('catatan_admin')->nullable()->after('status_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['status_user', 'catatan_admin']);
        });
    }
};