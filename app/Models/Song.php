<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    protected $fillable = [
        'name',
        'user_id',
        'thumbnail_url',
        'song_url',
    ];
}
