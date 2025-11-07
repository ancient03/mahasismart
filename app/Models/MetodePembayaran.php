<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MetodePembayaran extends Model
{
    use HasFactory;

    protected $table = 'metode_pembayaran';
    protected $primaryKey = 'id_metode_pembayaran';

    // ==========================================================
    // 👇 TAMBAHKAN BARIS INI 👇
    // ==========================================================
    /**
     * Menunjukkan jika model harus diberi stempel waktu (timestamps).
     *
     * @var bool
     */
    public $timestamps = false; // <-- INI PERBAIKANNYA

    /**
     * Atribut yang boleh diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_metode',
        'kode_metode',
        'deskripsi',
        'gambar_logo',
        'is_aktif',
    ];

    /**
     * Atribut yang harus di-cast ke tipe native.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    /**
     * Mendapatkan semua transaksi yang menggunakan metode pembayaran ini.
     */
    public function transaksi(): HasMany
    {
        return $this->hasMany(Transaksi::class, 'id_metode_pembayaran', 'id_metode_pembayaran');
    }
}