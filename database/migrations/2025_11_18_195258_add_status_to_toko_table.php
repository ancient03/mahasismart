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
        Schema::table('toko', function (Blueprint $table) {
            // status: 'aktif', 'peringatan', 'banned'
            $table->string('status_toko')->default('aktif')->after('logo_toko');
            // catatan admin: alasan kenapa dibanned/diperingatkan
            $table->text('catatan_admin')->nullable()->after('status_toko');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('toko', function (Blueprint $table) {
            $table->dropColumn(['status_toko', 'catatan_admin']);
        });
    }
};