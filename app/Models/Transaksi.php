<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $fillable = [
        'id_user',
        'id_alamat',
        'nomor_invoice',
        'total_harga_keseluruhan',
        'status_pembayaran',
        'status_pengiriman',
        'tanggal_transaksi',
    ];

    /**
     * Relasi ke User (Pembeli).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
    // ==========================================================
    // 👆 AKHIR METHOD RELASI 👆
    // ==========================================================


    /**
     * Relasi ke Alamat Pengiriman.
     */
    public function alamat(): BelongsTo
    {
        return $this->belongsTo(Alamat::class, 'id_alamat', 'id_alamat');
    }

    /**
     * Relasi ke Detail Transaksi (Item-item dalam pesanan ini).
     */
    public function detail(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_transaksi', 'id_transaksi');
    }
}
