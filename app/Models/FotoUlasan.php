<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoUlasan extends Model
{
    // Nama tabel di database
    protected $table = 'foto_ulasan';

    // Primary Key
    protected $primaryKey = 'id_foto_ulasan';

    // Tabel ini tidak punya timestamps (created_at, updated_at)
    public $timestamps = false;

    // Kolom yang boleh diisi
    protected $fillable = [
        'id_ulasan',
        'path_foto',
    ];

    /**
     * Relasi ke Ulasan (Induk).
     */
    public function ulasan(): BelongsTo
    {
        return $this->belongsTo(Ulasan::class, 'id_ulasan', 'id_ulasan');
    }
}