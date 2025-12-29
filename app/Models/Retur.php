<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retur extends Model
{
    use HasFactory;

    protected $table = 'retur';

    protected $fillable = [
        'detail_transaksi_id',
        'alasan',
        'catatan',
        'status',
    ];

    public function detailTransaksi()
    {
        return $this->belongsTo(DetailTransaksi::class, 'detail_transaksi_id');
    }
}
