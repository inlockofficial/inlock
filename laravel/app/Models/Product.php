<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Order;

class Product extends Model
{

    protected $fillable = [
        'user_id',
        'ali_link',
        'size',
        'color',
        'gender',
        'quantity',
        'custom_note',
        'screenshot',
        'status',
        // admin fields (⚠️ missing before)
        'title',
        'image',
        'price_usd',
        'shipping_usd',
        'final_price_dzd',
        'rate_used',
    ];
/*
    public function user()
    {
        return $this->belongsTo(User::class);
    }
*/
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}