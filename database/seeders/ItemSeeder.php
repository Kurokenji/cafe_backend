<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Item;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Item::insert([
            [
                'name' => 'Cà phê đen',
                'img' => 'images/cf_den.jpg',
                'price' => 15000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Cà phê sữa',
                'img' => 'images/cf_sua.jpg',
                'price' => 18000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Trà đào',
                'img' => 'images/tra_dao.jpg',
                'price' => 25000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Nước cam',
                'img' => 'images/nuoc_cam.jpg',
                'price' => 22000,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'name' => 'Sinh tố xoài',
                'img' => 'images/sinh_to_xoai.jpg',
                'price' => 30000,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}
