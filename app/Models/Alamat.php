<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
<<<<<<< HEAD
use Illuminate\Database\Eloquent\Relations\BelongsTo;
=======
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4

class Alamat extends Model
{
    use HasFactory;

<<<<<<< HEAD
    protected $table = 'alamat';
    protected $primaryKey = 'id_alamat';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_user',
=======
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
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
        'label',
        'nama_penerima',
        'no_hp_penerima',
        'provinsi',
<<<<<<< HEAD
        'province_id',    // Tambahan
        'kota',
        'city_id',        // Tambahan
        'kecamatan',
        'district_id',
        'desa', // TAMBAHAN KOLOM BARU
=======
        'kota',
        'kecamatan',
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
        'kode_pos',
        'detail_alamat',
        'is_default',
    ];

<<<<<<< HEAD
    protected $casts = [
        'is_default' => 'boolean',
    ];

    public function user(): BelongsTo
    {
=======
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
>>>>>>> 441768e18805edb3d840ea4992a0dc7e75bba5f4
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }
}
