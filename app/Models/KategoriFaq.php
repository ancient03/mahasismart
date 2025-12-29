<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriFaq extends Model
{
    // Mendefinisikan nama tabel secara eksplisit
    protected $table = 'kategori_faq';

    // Menentukan kolom mana saja yang boleh diisi (mass assignment)
    protected $fillable = ['nama_kategori_faq'];

    /**
     * Relasi ke model Faq.
     * Satu kategori memiliki banyak pertanyaan (FAQ).
     */
    public function faqs()
    {
        // Pastikan foreign key 'kategori_id' sesuai dengan yang ada di tabel faq
        return $this->hasMany(Faq::class, 'kategori_id');
    }
}