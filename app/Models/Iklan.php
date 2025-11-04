<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Iklan extends Model
{
    use HasFactory;

    protected $table = 'iklan'; // nama tabel

    protected $fillable = [
        'nama_iklan',
        'slogan',
        'deskripsi',
        'gambar',
        'dimulai',
        'berakhir',
    ];
}
