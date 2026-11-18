<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = ['wishnote_id', 'user_id', 'body', 'display_name', 'ornament', 'x', 'y'];

    public function wishnote()
    {
        return $this->belongsTo(\App\Models\WishNote::class, 'wishnote_id');
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
