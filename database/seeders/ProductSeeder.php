<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Data dummy untuk produk
        $products = [
            [
                'name' => 'Nasi Goreng',
                'price' => 15000,
                'stock' => 50,
            ],
            [
                'name' => 'Mie Goreng',
                'price' => 12000,
                'stock' => 30,
            ],
            [
                'name' => 'Ayam Bakar',
                'price' => 25000,
                'stock' => 20,
            ],
            [
                'name' => 'Es Teh',
                'price' => 5000,
                'stock' => 100,
            ],
            [
                'name' => 'Es Jeruk',
                'price' => 7000,
                'stock' => 80,
            ],
        ];

        // Insert data ke tabel products
        foreach ($products as $product) {
            Product::create($product);
        }
    }
}