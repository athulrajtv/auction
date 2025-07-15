<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'category_id',
        'product_name',
        'price',
        'stream_url',
        'image',
        'start_time',
        'duration_seconds',
        'current_price',
        'last_bid_user'
    ];
}
