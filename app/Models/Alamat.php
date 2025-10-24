<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo

class Alamat extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'alamat'; // Beri tahu Eloquent nama tabelnya

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'id_alamat'; // Beri tahu Eloquent primary key-nya

    /**
     * Menunjukkan jika ID auto-increment.
     * (Defaultnya true, jadi tidak wajib, tapi bisa ditambahkan untuk kejelasan)
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipe data primary key.
     * (Defaultnya int, jadi tidak wajib jika PK Anda integer)
     *
     * @var string
     */
    protected $keyType = 'int';


    /**
     * Atribut yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_user',         // Foreign key harus ada di fillable
        'label',
        'nama_penerima',
        'no_hp_penerima',
        'provinsi',
        'kota',
        'kecamatan',
        'kode_pos',
        'detail_alamat',
        'is_default',
    ];

    /**
     * Atribut yang harus di-cast ke tipe native.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'is_default' => 'boolean', // Pastikan is_default selalu boolean
    ];

    /**
     * Mendapatkan user (pemilik) dari alamat ini.
     * Relasi BelongsTo (Satu Alamat dimiliki oleh Satu User).
     */
    public function user(): BelongsTo
    {
        // Parameter:
        // 1. Model terkait (User::class)
        // 2. Foreign key di tabel ini ('id_user')
        // 3. Owner key (primary key di tabel users, yaitu 'id_user')
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
