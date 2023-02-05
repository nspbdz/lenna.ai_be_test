<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;
    protected $fillable = [
        'sender',
        'receiver',
        'message',
    ];
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver');

    }
}
