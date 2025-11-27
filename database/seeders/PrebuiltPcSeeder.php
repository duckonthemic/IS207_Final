<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ComponentType;
use App\Models\SpecDefinition;
use App\Models\ProductSpec;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PrebuiltPcSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Categories
        $categories = [
            'pc-gaming' => 'PC Gaming',
            'pc-ai-workstation' => 'PC AI Workstation',
            'pc-office' => 'PC Office',
            'pc-design' => 'PC Design',
        ];

        $categoryIds = [];
        foreach ($categories as $slug => $name) {
            $cat = Category::firstOrCreate(
                ['slug' => $slug],
                ['name' => $name, 'description' => "Pre-built $name systems"]
            );
            $categoryIds[$slug] = $cat->id;
        }

        // 2. Create Component Type for PC System
        $componentType = ComponentType::firstOrCreate(
            ['code' => 'pc-system'],
            ['name' => 'PC System']
        );

        // 3. Define Specs for PC Systems
        $specs = [
            'cpu' => 'CPU',
            'gpu' => 'VGA',
            'ram' => 'RAM',
            'storage' => 'Lưu trữ',
            'psu' => 'Nguồn',
            'case' => 'Vỏ Case',
        ];

        $specDefIds = [];
        foreach ($specs as $code => $name) {
            $def = SpecDefinition::firstOrCreate(
                ['code' => "pc_system_$code"],
                [
                    'name' => $name,
                    'component_type_id' => $componentType->id,
                    'input_type' => 'text',
                    'is_filterable' => true,
                ]
            );
            $specDefIds[$code] = $def->id;
        }

        // 4. Create Products
        $products = [
            // PC Gaming
            [
                'category' => 'pc-gaming',
                'name' => 'PC Gaming - Glacier i5050 - BL',
                'price' => 17990000,
                'sale_price' => 16490000,
                'specs' => [
                    'cpu' => 'Intel Core i5-13400F',
                    'gpu' => 'NVIDIA RTX 4060 8GB',
                    'ram' => '16GB DDR4 3200MHz',
                    'storage' => '500GB NVMe SSD',
                    'psu' => '650W 80+ Bronze',
                    'case' => 'Xigmatek Gaming X 3F',
                ],
                'image' => 'https://product.hstatic.net/200000722513/product/pc-gaming-glacier-i3050_8c6f8f8f8f8f4f8f8f8f8f8f8f8f8f8f.jpg',
            ],
            [
                'category' => 'pc-gaming',
                'name' => 'PC Gaming - Supernova i5080 - WH',
                'price' => 70240000,
                'sale_price' => 66990000,
                'specs' => [
                    'cpu' => 'Intel Core i7-14700KF',
                    'gpu' => 'NVIDIA RTX 4080 Super 16GB',
                    'ram' => '32GB DDR5 6000MHz',
                    'storage' => '1TB NVMe Gen4 SSD',
                    'psu' => '850W 80+ Gold',
                    'case' => 'NZXT H9 Flow White',
                ],
                'image' => 'https://product.hstatic.net/200000722513/product/pc-gaming-supernova-i5080-wh_8c6f8f8f8f8f4f8f8f8f8f8f8f8f8f8f.jpg',
            ],
            [
                'category' => 'pc-gaming',
                'name' => 'PC Gaming - Sniper A9060XT',
                'price' => 38790000,
                'sale_price' => null,
                'specs' => [
                    'cpu' => 'AMD Ryzen 7 7800X3D',
                    'gpu' => 'AMD Radeon RX 7800 XT 16GB',
                    'ram' => '32GB DDR5 6000MHz',
                    'storage' => '1TB NVMe SSD',
                    'psu' => '750W 80+ Gold',
                    'case' => 'Corsair 4000D Airflow',
                ],
                'image' => 'https://product.hstatic.net/200000722513/product/pc-gaming-sniper-a9060xt_8c6f8f8f8f8f4f8f8f8f8f8f8f8f8f8f.jpg',
            ],

            // PC AI
            [
                'category' => 'pc-ai-workstation',
                'name' => 'PC AI Workstation Pro',
                'price' => 97990000,
                'sale_price' => 95990000,
                'specs' => [
                    'cpu' => 'AMD Ryzen 9 7950X',
                    'gpu' => 'NVIDIA RTX 4090 24GB',
                    'ram' => '128GB DDR5 5600MHz',
                    'storage' => '2TB NVMe Gen5 SSD',
                    'psu' => '1200W 80+ Platinum',
                    'case' => 'Fractal Design North XL',
                ],
                'image' => 'https://product.hstatic.net/200000722513/product/pc-ai-workstation-pro_8c6f8f8f8f8f4f8f8f8f8f8f8f8f8f8f.jpg',
            ],
            [
                'category' => 'pc-ai-workstation',
                'name' => 'PC AI Studio',
                'price' => 68990000,
                'sale_price' => 66990000,
                'specs' => [
                    'cpu' => 'Intel Core i9-14900K',
                    'gpu' => 'NVIDIA RTX 4080 Super 16GB',
                    'ram' => '64GB DDR5 6000MHz',
                    'storage' => '1TB NVMe Gen4 SSD',
                    'psu' => '1000W 80+ Gold',
                    'case' => 'Lian Li O11 Dynamic Evo',
                ],
                'image' => 'https://product.hstatic.net/200000722513/product/pc-ai-studio_8c6f8f8f8f8f4f8f8f8f8f8f8f8f8f.jpg',
            ],

            // PC Office
            [
                'category' => 'pc-office',
                'name' => 'PC Office Premium',
                'price' => 22990000,
                'sale_price' => 21490000,
                'specs' => [
                    'cpu' => 'Intel Core i7-14700',
                    'gpu' => 'Intel UHD Graphics 770',
                    'ram' => '32GB DDR5 5600MHz',
                    'storage' => '512GB NVMe SSD',
                    'psu' => '550W 80+ Bronze',
                    'case' => 'Deepcool Macube 110',
                ],
                'image' => 'https://product.hstatic.net/200000722513/product/pc-office-premium_8c6f8f8f8f8f4f8f8f8f8f8f8f8f8f.jpg',
            ],
            [
                'category' => 'pc-office',
                'name' => 'PC Office Standard',
                'price' => 16990000,
                'sale_price' => 15490000,
                'specs' => [
                    'cpu' => 'Intel Core i5-14400',
                    'gpu' => 'Intel UHD Graphics 730',
                    'ram' => '16GB DDR5 5200MHz',
                    'storage' => '512GB NVMe SSD',
                    'psu' => '500W 80+ White',
                    'case' => 'Xigmatek XA-24',
                ],
                'image' => 'https://product.hstatic.net/200000722513/product/pc-office-standard_8c6f8f8f8f8f4f8f8f8f8f8f8f8f8f.jpg',
            ],

            // PC Design
            [
                'category' => 'pc-design',
                'name' => 'PC Design Ultra',
                'price' => 72990000,
                'sale_price' => 69990000,
                'specs' => [
                    'cpu' => 'AMD Ryzen 9 7950X3D',
                    'gpu' => 'NVIDIA RTX 4080 Super 16GB',
                    'ram' => '64GB DDR5 6000MHz',
                    'storage' => '2TB NVMe Gen4 SSD',
                    'psu' => '1000W 80+ Gold',
                    'case' => 'Hyte Y60',
                ],
                'image' => 'https://product.hstatic.net/200000722513/product/pc-design-ultra_8c6f8f8f8f8f4f8f8f8f8f8f8f8f8f.jpg',
            ],
            [
                'category' => 'pc-design',
                'name' => 'PC Design Starter',
                'price' => 42990000,
                'sale_price' => 40990000,
                'specs' => [
                    'cpu' => 'AMD Ryzen 7 7700X',
                    'gpu' => 'NVIDIA RTX 4070 Super 12GB',
                    'ram' => '32GB DDR5 6000MHz',
                    'storage' => '1TB NVMe SSD',
                    'psu' => '750W 80+ Gold',
                    'case' => 'Montech Sky Two',
                ],
                'image' => 'https://product.hstatic.net/200000722513/product/pc-design-starter_8c6f8f8f8f8f4f8f8f8f8f8f8f8f8f.jpg',
            ],
        ];

        foreach ($products as $p) {
            $product = Product::updateOrCreate(
                ['slug' => Str::slug($p['name'])],
                [
                    'name' => $p['name'],
                    'category_id' => $categoryIds[$p['category']],
                    'component_type_id' => $componentType->id,
                    'price' => $p['price'],
                    'sale_price' => $p['sale_price'],
                    'sku' => Str::upper(Str::random(8)),
                    'stock' => 10,
                    'is_active' => true,
                    'description' => "Cấu hình chi tiết:\n" . implode("\n", array_map(fn($k, $v) => "- $k: $v", array_keys($p['specs']), $p['specs'])),
                    'image' => $p['image'], // In real app, this would be a local path or uploaded URL
                ]
            );

            // Add Specs
            foreach ($p['specs'] as $code => $value) {
                ProductSpec::updateOrCreate(
                    [
                        'product_id' => $product->id,
                        'spec_definition_id' => $specDefIds[$code],
                    ],
                    ['value' => $value]
                );
            }
        }
    }
}
