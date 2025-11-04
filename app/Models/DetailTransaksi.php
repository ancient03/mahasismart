<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Import BelongsTo untuk relasi

class DetailTransaksi extends Model
{
    use HasFactory;

    /**
     * Nama tabel yang terkait dengan model.
     *
     * @var string
     */
    protected $table = 'detail_transaksi';

    /**
     * Primary key untuk model.
     *
     * @var string
     */
    protected $primaryKey = 'id_detail_transaksi';

    /**
     * Atribut yang boleh diisi secara massal (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id_transaksi',
        'id_barang',
        'id_toko',
        'kuantitas',
        'harga_saat_transaksi', // 'Harga terkunci' saat checkout
    ];

    /**
     * Menentukan apakah model harus memiliki timestamps.
     * (Migrasi kita memiliki timestamps(), jadi ini 'true' secara default)
     *
     * @var bool
     */
    // public $timestamps = true; // Tidak perlu ditulis jika 'true'

    /**
     * Relasi BelongsTo: Detail ini milik SATU Transaksi (induk).
     */
    public function transaksi(): BelongsTo
    {
        // (Foreign Key, Owner Key)
        return $this->belongsTo(Transaksi::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * Relasi BelongsTo: Detail ini merujuk ke SATU Barang.
     */
    public function barang(): BelongsTo
    {
        // Gunakan 'withTrashed' agar info barang tetap muncul 
        // meskipun barangnya sudah di-soft delete oleh penjual
        return $this->belongsTo(Barang::class, 'id_barang', 'id_barang');
    }

    /**
     * Relasi BelongsTo: Detail ini merujuk ke SATU Toko.
     */
    public function toko(): BelongsTo
    {
        return $this->belongsTo(Toko::class, 'id_toko', 'id_toko');
    }
}

