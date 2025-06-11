<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $order = Order::create([
            'table' => 'Bàn 1',
            'status' => 'pending'
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'item_id' => 1, // Cà phê đen
            'quantity' => 2,
            'total_price' => 2 * 15000,
        ]);

        OrderItem::create([
            'order_id' => $order->id,
            'item_id' => 3, // Trà đào
            'quantity' => 1,
            'total_price' => 1 * 25000,
        ]);
    }
}
