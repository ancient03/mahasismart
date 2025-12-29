<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model {
    protected $table = 'faq';
    protected $fillable = ['kategori_id', 'pertanyaan', 'jawaban'];

    public function kategori() {
        return $this->belongsTo(KategoriFaq::class, 'kategori_id');
    }
}
