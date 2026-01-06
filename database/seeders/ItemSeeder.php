<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
   public function run(): void
{
    $items = [
        [
            'category_id' => 2, 
            'name' => 'Mikroskop',
            'stock' => 5,
            'description' => 'Mikroskop digital'
        ],
        [
            'category_id' => 1, 
            'name' => 'Beaker Glass 250ml',
            'stock' => 10,
            'description' => 'Gelas ukur'
        ],
        [
            'category_id' => 2, 
            'name' => 'Laptop Dell',
            'stock' => 3,
            'description' => 'Laptop praktikum'
        ],
    ];

    foreach ($items as $item) {
        \App\Models\Item::create($item);
    }
}
}
