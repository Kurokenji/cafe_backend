<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = ['table', 'status', 'total_price'];
    public function order_items()
    {
        return $this->hasMany(OrderItem::class);
    }

}
