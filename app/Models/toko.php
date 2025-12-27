<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
// 👇 TAMBAHKAN IMPORT INI 👇
use Illuminate\Database\Eloquent\Relations\HasMany; 

class Toko extends Model
{
    use HasFactory;

    protected $table = 'toko';
    protected $primaryKey = 'id_toko';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'nama_toko',
        'no_hp_toko',
        'status_toko',
        'no_rek',     
        'logo_toko',
        'banner_toko',
    ];

    /**
     * Relasi ke User (pemilik toko).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    // =============================================
    // 👇 TAMBAHKAN METHOD RELASI BARANG INI 👇
    // =============================================
    /**
     * Mendapatkan semua barang yang dimiliki oleh toko ini.
     * Relasi HasMany (Satu Toko memiliki Banyak Barang).
     */
    public function barang(): HasMany 
    {
        // Parameter: Model terkait, Foreign key di tabel barang, Local key (PK di tabel toko)
        return $this->hasMany(Barang::class, 'id_toko', 'id_toko');
    }
    // =============================================
    // 👆 AKHIR METHOD RELASI BARANG 👆
    // =============================================

        // ==========================================================
    // 👇 TAMBAHKAN RELASI INI 👇
    // ==========================================================
    /**
     * Mendapatkan semua item pesanan (detail transaksi) untuk toko ini.
     */
    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_toko', 'id_toko');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class, 'toko_id');
    }
}

