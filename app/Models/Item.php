<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'img', 'price','category_id'];
    
    public function orders() {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity')
                    ->withTimestamps();
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }


}
