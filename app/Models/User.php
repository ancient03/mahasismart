<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * MODIFIKASI 1: Menentukan Primary Key
     */
    protected $primaryKey = 'id_user';

    /**
     * MODIFIKASI 2: Menentukan Tipe Data Primary Key
     */
    protected $keyType = 'int';

    /**
     * MODIFIKASI 3: Menegaskan Auto-Increment
     */
    public $incrementing = true;

    /**
     * MODIFIKASI 4: Kolom yang Boleh Diisi (Mass Assignable)
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'no_hp',
        'tanggal',
        'foto_profil', // <-- TAMBAHKAN BARIS INI
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}