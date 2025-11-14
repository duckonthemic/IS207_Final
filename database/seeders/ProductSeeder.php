<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $categories = Category::all();
        
        if ($categories->isEmpty()) {
            $this->command->warn('No categories found. Run CategorySeeder first.');
            return;
        }

        $brands = ['Intel', 'AMD', 'NVIDIA', 'Corsair', 'Kingston', 'Samsung', 'Western Digital', 'Seagate'];
        
        // Sample products
        $products = [
            [
                'name' => 'Intel Core i9-13900K',
                'category' => 'CPU',
                'price' => 15000000,
                'brand' => 'Intel',
                'specifications' => [
                    'cores' => 24,
                    'threads' => 32,
                    'base_clock' => '3.0 GHz',
                    'boost_clock' => '5.8 GHz',
                    'tdp' => '125W',
                ]
            ],
            [
                'name' => 'AMD Ryzen 9 7950X',
                'category' => 'CPU',
                'price' => 14000000,
                'brand' => 'AMD',
                'specifications' => [
                    'cores' => 16,
                    'threads' => 32,
                    'base_clock' => '4.5 GHz',
                    'boost_clock' => '5.7 GHz',
                    'tdp' => '170W',
                ]
            ],
            [
                'name' => 'NVIDIA RTX 4090',
                'category' => 'GPU',
                'price' => 45000000,
                'brand' => 'NVIDIA',
                'specifications' => [
                    'memory' => '24GB GDDR6X',
                    'cuda_cores' => 16384,
                    'boost_clock' => '2.52 GHz',
                    'tdp' => '450W',
                ]
            ],
            [
                'name' => 'AMD RX 7900 XTX',
                'category' => 'GPU',
                'price' => 25000000,
                'brand' => 'AMD',
                'specifications' => [
                    'memory' => '24GB GDDR6',
                    'compute_units' => 96,
                    'boost_clock' => '2.5 GHz',
                    'tdp' => '355W',
                ]
            ],
            [
                'name' => 'Corsair Vengeance DDR5 32GB',
                'category' => 'RAM',
                'price' => 5000000,
                'brand' => 'Corsair',
                'specifications' => [
                    'capacity' => '32GB (2x16GB)',
                    'type' => 'DDR5',
                    'speed' => '6000MHz',
                    'latency' => 'CL36',
                ]
            ],
            [
                'name' => 'Samsung 980 PRO 1TB',
                'category' => 'SSD',
                'price' => 3500000,
                'brand' => 'Samsung',
                'specifications' => [
                    'capacity' => '1TB',
                    'interface' => 'NVMe PCIe 4.0',
                    'read_speed' => '7000 MB/s',
                    'write_speed' => '5000 MB/s',
                ]
            ],
        ];

        foreach ($products as $productData) {
            $category = $categories->firstWhere('name', $productData['category']);
            
            if (!$category) {
                $category = $categories->random();
            }

            Product::create([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => 'Sản phẩm chất lượng cao, chính hãng',
                'price' => $productData['price'],
                'sku' => strtoupper(Str::random(8)),
                'stock' => rand(10, 50),
                'brand' => $productData['brand'],
                'specifications' => $productData['specifications'],
                'image' => 'https://via.placeholder.com/400?text=' . urlencode($productData['name']),
            ]);
        }

        $this->command->info('Created ' . count($products) . ' sample products.');
    }
}
