<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// 👇 PASTIKAN IMPORT INI ADA 👇
use Illuminate\Database\Eloquent\Relations\HasMany; 
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $primaryKey = 'id_user';
    protected $keyType = 'int';
    public $incrementing = true;

    protected $fillable = [
        'username',
        'email',
        'password',
        'no_hp',
        'role', 
        'tanggal',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // =============================================
    // 👇 PASTIKAN METHOD RELASI INI ADA 👇
    // =============================================
    /**
     * Mendapatkan semua alamat yang dimiliki oleh User.
     * Relasi HasMany (Satu User memiliki Banyak Alamat).
     */
    public function alamat(): HasMany
    {
        // Parameter: Model terkait, Foreign key, Local key
        return $this->hasMany(Alamat::class, 'id_user', 'id_user');
    }
    // =============================================
    // 👆 AKHIR METHOD RELASI 👆
    // =============================================

    public function toko(): HasOne 
    {
        // Parameter: Model terkait, Foreign key, Local key
        return $this->hasOne(Toko::class, 'id_user', 'id_user');
    }

    public function keranjang(): BelongsToMany
    {
        return $this->belongsToMany(Barang::class, 'keranjang', 'id_user', 'id_barang')
                    ->withPivot('kuantitas') // Penting: Ambil info kuantitas juga
                    ->withTimestamps(); // Ambil info kapan ditambahkan
    }

        public function transaksi(): HasMany
    {
        // Relasi satu user memiliki banyak transaksi
        return $this->hasMany(Transaksi::class, 'id_user', 'id_user');
    }
}