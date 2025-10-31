<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'barang';
    protected $primaryKey = 'id_barang';

    /**
     * Atribut yang boleh diisi secara massal.
     */
    protected $fillable = [
        'id_toko',
        'id_kategori', // Pastikan nama ini sesuai migrasi
        'nama_barang',
        'harga',
        'foto_barang', // Pastikan ini ada
        'deskripsi', 
    ];

    /**
     * Relasi ke Toko.
     */
    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id_toko');
    }

    /**
     * Relasi ke Kategori.
     */
    public function kategori(): BelongsTo
    {
        // Pastikan 'id_kategori' sesuai dengan foreign key Anda
        // Pastikan Model Kategori sudah ada (App\Models\Kategori)
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori'); 
    }


}
