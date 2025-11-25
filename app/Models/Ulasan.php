<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ulasan extends Model
{
    protected $table = 'ulasan';
    protected $primaryKey = 'id_ulasan';
    protected $fillable = ['id_user', 'id_barang', 'id_transaksi', 'rating', 'komentar'];

    public function user(): BelongsTo { return $this->belongsTo(User::class, 'id_user', 'id_user'); }
    public function barang(): BelongsTo { return $this->belongsTo(Barang::class, 'id_barang', 'id_barang'); }
    public function fotoUlasan(): HasMany { return $this->hasMany(FotoUlasan::class, 'id_ulasan', 'id_ulasan'); }
}