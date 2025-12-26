<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    use HasFactory;

    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_user',
        'id_transaksi',
        'jenis_masalah',
        'deskripsi',
        'bukti_foto',
        'status_laporan',
    ];

    /**
     * Relasi ke User (Pelapor).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Transaksi yang dilaporkan.
     */
    public function transaksi(): BelongsTo
    {
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }
}