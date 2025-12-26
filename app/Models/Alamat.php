<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Alamat extends Model
{
    use HasFactory;

    protected $table = 'alamat';
    protected $primaryKey = 'id_alamat';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
        'label',
        'nama_penerima',
        'no_hp_penerima',
        'provinsi',
        'province_id',    // Tambahan
        'kota',
        'city_id',        // Tambahan
        'kecamatan',
        'district_id',
        'desa', // TAMBAHAN KOLOM BARU
        'kode_pos',
        'detail_alamat',
        'is_default',
    ];

    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
