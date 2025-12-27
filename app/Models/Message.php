<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'toko_id',
        'message',
        'read_at',
    ];

    /**
     * Get the sender of the message.
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    /**
     * Get the toko that received the message.
     */
    public function toko()
    {
        return $this->belongsTo(Toko::class);
    }
}
