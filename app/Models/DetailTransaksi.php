<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailTransaksi extends Model
{
    use HasFactory;

    protected $table = 'detail_transaksi';
    protected $primaryKey = 'id_detail';
    
    // Nonaktifkan timestamps (created_at, updated_at) jika tabel Anda tidak memilikinya
    // public $timestamps = false; 

    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'id_toko',
        'kuantitas',
        'harga_saat_transaksi',
    ];

    /**
     * Relasi ke Transaksi (induk).
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * Relasi ke Barang yang dibeli.
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    /**
     * Relasi ke Toko (penjual).
     */
    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id_toko');
    }
}
