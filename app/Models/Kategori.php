<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany; // Import HasMany untuk relasi ke Barang

class Kategori extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'kategori';

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'id_kategori';

    /**
     * Menunjukkan jika ID auto-increment.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipe data primary key.
     *
     * @var string
     */
    protected $keyType = 'int';


    /**
     * Atribut yang boleh diisi secara massal.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_kategori',
        'total_produk', // Jika Anda mengelola ini
    ];

    /**
     * Menentukan apakah model harus memiliki timestamps (created_at, updated_at).
     * Set ke false jika tabel Anda tidak punya kolom timestamps.
     *
     * @var bool
     */
    public $timestamps = false; // Sesuaikan jika tabel Anda punya timestamps

    /**
     * Mendapatkan semua barang dalam kategori ini.
     */
    public function barang(): HasMany
    {
        // Parameter: Model terkait, Foreign key di tabel barang, Local key (PK di tabel kategori)
        return $this->hasMany(Barang::class, 'id_kategori', 'id_kategori');
    }
}
