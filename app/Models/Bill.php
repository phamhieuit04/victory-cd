<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    protected $fillable = [
        'song_id',
        'order_code',
        'code_url',
        'checkout_url',
        'price',
        'status',
    ];
}
