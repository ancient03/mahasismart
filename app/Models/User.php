<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// 👇 PASTIKAN IMPORT INI ADA 👇
use Illuminate\Database\Eloquent\Relations\HasMany; 

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
}