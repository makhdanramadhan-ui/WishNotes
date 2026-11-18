<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WishNote extends Model
{
    protected $fillable = [
        'judul',
        'deskripsi_singkat',
        'tipe_wadah',
        'privasi',
        'users_id',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'users_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class, 'wishnote_id');
    }
}
