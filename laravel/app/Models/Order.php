<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'product_title',
        'product_image',
        'price_usd',
        'rate_used',
        'total_dzd',
        'status',
        'expires_at',

        // checkout info
        'full_name',
        'email',
        'phone',
        'address',
        'city',
        'postal_code',
        'notes',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isExpired()
    {
        return $this->expires_at && now()->greaterThan($this->expires_at);
    }

    public function payments()
    {
        return $this->hasMany(ChargilyPayment::class);
    }
}
