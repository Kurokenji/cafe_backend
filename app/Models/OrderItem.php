<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'item_id',
        'quantity',
    ];

    // Quan hệ đến Order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // Quan hệ đến Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
