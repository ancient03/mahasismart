<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Keranjang extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     */
    protected $table = 'keranjang';

    /**
     * Primary key untuk model.
     */
    protected $primaryKey = 'id_keranjang';

    /**
     * Atribut yang boleh diisi secara massal (mass assignable).
     */
    protected $fillable = [
        'id_user',
        'id_barang',
        'kuantitas',
    ];

    /**
     * Relasi ke User (pemilik keranjang).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Barang (item di keranjang).
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }
}
