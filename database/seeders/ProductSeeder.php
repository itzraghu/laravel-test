<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->create([
            'name' => 'Gold Coffee',
            'profit_margin_percent' => 25,
            'unit_cost' => 10
        ]);

        Product::factory()->create([
            'name' => 'Arabic coffee',
            'profit_margin_percent' => 15,
            'unit_cost' => 20.50
        ]);
    }
}
