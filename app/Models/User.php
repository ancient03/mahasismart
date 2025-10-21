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
     * Memberi tahu Laravel bahwa Primary Key tabel ini adalah 'id_user'.
     */
    protected $primaryKey = 'id_user';

    /**
     * MODIFIKASI 2: Menentukan Tipe Data Primary Key
     * Menyesuaikan tipe data PK menjadi 'int' agar cocok dengan $table->increments().
     */
    protected $keyType = 'int';

    /**
     * MODIFIKASI 3: Menegaskan Auto-Increment
     * Memberi tahu Laravel bahwa PK ini auto-increment.
     */
    public $incrementing = true;

    /**
     * MODIFIKASI 4: Kolom yang Boleh Diisi (Mass Assignable)
     *
     * @var list<string>
     */
    protected $fillable = [
        'username', // <-- Diubah dari 'name'
        'email',
        'password',
        'no_hp',    // <-- Ditambahkan
        'tanggal',  // <-- Ditambahkan
    ];

    /**
     * The attributes that should be hidden for serialization.
     * (Tidak perlu diubah)
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     * (Tidak perlu diubah)
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}