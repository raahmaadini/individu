<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Jaket',
            'price' => 50000,
            'size' => 'M',
            'stock' => 10,
            'description' => 'Jaket',
        ]);

        Product::create([
            'name' => 'Hoodie',
            'price' => 100000,
            'size' => 'M',
            'stock' => 5,
            'description' => 'Hoodie Hitam',
        ]);

        Product::create([
            'name' => 'Sweater',
            'price' => 70000,
            'size' => 'S',
            'stock' => 10,
            'description' => 'Sweater Putih',
        ]);

        Product::create([
            'name' => 'Kaos',
            'price' => 50000,
            'size' => 'L',
            'stock' => 25,
            'description' => 'Kaos Hitam',
        ]);

        Product::create([
            'name' => 'Kemeja',
            'price' => 120000,
            'size' => 'M',
            'stock' => 7,
            'description' => 'Kemeja Merah',
        ]);
    }
}