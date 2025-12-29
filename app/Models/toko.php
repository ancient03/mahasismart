<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Crypt;

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
        'nama_lengkap',
        'nik_nim',
        'foto_verifikasi',
        'jenis_verifikasi',
        'is_verified',
    ];

    protected $casts = [
        'is_verified' => 'boolean',
    ];

    /**
     * Enkripsi NIK/NIM sebelum disimpan
     */
    public function setNikNimAttribute($value)
    {
        $this->attributes['nik_nim'] = Crypt::encryptString($value);
    }

    /**
     * Dekripsi NIK/NIM saat diambil
     */
    public function getNikNimAttribute($value)
    {
        try {
            return Crypt::decryptString($value);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Relasi ke User (pemilik toko).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    /**
     * Relasi ke Barang
     */
    public function barang(): HasMany 
    {
        return $this->hasMany(Barang::class, 'id_toko', 'id_toko');
    }

    /**
     * Relasi ke Detail Transaksi
     */
    public function detailTransaksi(): HasMany
    {
        return $this->hasMany(DetailTransaksi::class, 'id_toko', 'id_toko');
    }
}