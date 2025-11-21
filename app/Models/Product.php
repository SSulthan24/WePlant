<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'stock',
        'category',
        'partner_id',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
