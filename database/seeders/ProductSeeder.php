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

        $products = [
            // CPU - Bộ xử lý
            ['name' => 'Intel Core i9-14900K', 'category' => 'CPU', 'price' => 16990000, 'sale_price' => 15490000, 'brand' => 'Intel', 'stock' => 25],
            ['name' => 'Intel Core i9-14900KF', 'category' => 'CPU', 'price' => 15990000, 'sale_price' => null, 'brand' => 'Intel', 'stock' => 20],
            ['name' => 'Intel Core i7-14700K', 'category' => 'CPU', 'price' => 12990000, 'sale_price' => 11990000, 'brand' => 'Intel', 'stock' => 35],
            ['name' => 'Intel Core i7-14700KF', 'category' => 'CPU', 'price' => 11990000, 'sale_price' => null, 'brand' => 'Intel', 'stock' => 30],
            ['name' => 'Intel Core i5-14600K', 'category' => 'CPU', 'price' => 8990000, 'sale_price' => 7990000, 'brand' => 'Intel', 'stock' => 45],
            ['name' => 'Intel Core i5-13600K', 'category' => 'CPU', 'price' => 7490000, 'sale_price' => 6990000, 'brand' => 'Intel', 'stock' => 40],
            ['name' => 'AMD Ryzen 9 7950X', 'category' => 'CPU', 'price' => 15990000, 'sale_price' => 14990000, 'brand' => 'AMD', 'stock' => 28],
            ['name' => 'AMD Ryzen 9 7900X', 'category' => 'CPU', 'price' => 12990000, 'sale_price' => null, 'brand' => 'AMD', 'stock' => 32],
            ['name' => 'AMD Ryzen 7 7800X3D', 'category' => 'CPU', 'price' => 11990000, 'sale_price' => 10990000, 'brand' => 'AMD', 'stock' => 38],
            ['name' => 'AMD Ryzen 7 7700X', 'category' => 'CPU', 'price' => 9490000, 'sale_price' => null, 'brand' => 'AMD', 'stock' => 35],
            ['name' => 'AMD Ryzen 5 7600X', 'category' => 'CPU', 'price' => 6990000, 'sale_price' => 5990000, 'brand' => 'AMD', 'stock' => 50],
            ['name' => 'AMD Ryzen 5 5600X', 'category' => 'CPU', 'price' => 4490000, 'sale_price' => 3990000, 'brand' => 'AMD', 'stock' => 55],
            
            // GPU - Card đồ họa
            ['name' => 'ASUS ROG Strix RTX 4090 OC 24GB', 'category' => 'GPU', 'price' => 59990000, 'sale_price' => 56990000, 'brand' => 'ASUS', 'stock' => 8],
            ['name' => 'MSI RTX 4090 Gaming X Trio 24GB', 'category' => 'GPU', 'price' => 57990000, 'sale_price' => null, 'brand' => 'MSI', 'stock' => 10],
            ['name' => 'Gigabyte RTX 4080 Super Gaming OC 16GB', 'category' => 'GPU', 'price' => 39990000, 'sale_price' => 37990000, 'brand' => 'Gigabyte', 'stock' => 15],
            ['name' => 'ASUS TUF RTX 4080 Super OC 16GB', 'category' => 'GPU', 'price' => 38990000, 'sale_price' => null, 'brand' => 'ASUS', 'stock' => 18],
            ['name' => 'MSI RTX 4070 Ti Super Gaming X Trio 16GB', 'category' => 'GPU', 'price' => 27990000, 'sale_price' => 25990000, 'brand' => 'MSI', 'stock' => 22],
            ['name' => 'Gigabyte RTX 4070 Super Windforce OC 12GB', 'category' => 'GPU', 'price' => 21990000, 'sale_price' => 19990000, 'brand' => 'Gigabyte', 'stock' => 28],
            ['name' => 'ASUS Dual RTX 4060 Ti OC 8GB', 'category' => 'GPU', 'price' => 13990000, 'sale_price' => null, 'brand' => 'ASUS', 'stock' => 35],
            ['name' => 'Sapphire RX 7900 XTX Nitro+ 24GB', 'category' => 'GPU', 'price' => 29990000, 'sale_price' => 27990000, 'brand' => 'Sapphire', 'stock' => 20],
            ['name' => 'PowerColor RX 7900 XT Red Devil 20GB', 'category' => 'GPU', 'price' => 24990000, 'sale_price' => null, 'brand' => 'PowerColor', 'stock' => 25],
            ['name' => 'XFX RX 7800 XT QICK 16GB', 'category' => 'GPU', 'price' => 17990000, 'sale_price' => 16490000, 'brand' => 'XFX', 'stock' => 30],
            ['name' => 'ASRock RX 7700 XT Challenger 12GB', 'category' => 'GPU', 'price' => 14990000, 'sale_price' => 13990000, 'brand' => 'ASRock', 'stock' => 32],
            
            // Mainboard
            ['name' => 'ASUS ROG Maximus Z790 Hero', 'category' => 'Mainboard', 'price' => 18990000, 'sale_price' => 17490000, 'brand' => 'ASUS', 'stock' => 15],
            ['name' => 'MSI MPG Z790 Carbon WiFi', 'category' => 'Mainboard', 'price' => 14990000, 'sale_price' => null, 'brand' => 'MSI', 'stock' => 20],
            ['name' => 'Gigabyte Z790 Aorus Elite AX', 'category' => 'Mainboard', 'price' => 9990000, 'sale_price' => 8990000, 'brand' => 'Gigabyte', 'stock' => 25],
            ['name' => 'ASRock Z790 Pro RS', 'category' => 'Mainboard', 'price' => 6990000, 'sale_price' => null, 'brand' => 'ASRock', 'stock' => 30],
            ['name' => 'ASUS ROG Strix X670E-E Gaming WiFi', 'category' => 'Mainboard', 'price' => 16990000, 'sale_price' => 15990000, 'brand' => 'ASUS', 'stock' => 18],
            ['name' => 'MSI MAG X670E Tomahawk WiFi', 'category' => 'Mainboard', 'price' => 12990000, 'sale_price' => null, 'brand' => 'MSI', 'stock' => 22],
            ['name' => 'Gigabyte X670 Aorus Elite AX', 'category' => 'Mainboard', 'price' => 8990000, 'sale_price' => 7990000, 'brand' => 'Gigabyte', 'stock' => 28],
            ['name' => 'ASRock B650E PG Riptide WiFi', 'category' => 'Mainboard', 'price' => 5990000, 'sale_price' => 5490000, 'brand' => 'ASRock', 'stock' => 35],
            
            // RAM
            ['name' => 'Corsair Dominator Platinum RGB DDR5 64GB (2x32GB) 6000MHz', 'category' => 'RAM', 'price' => 11990000, 'sale_price' => 10990000, 'brand' => 'Corsair', 'stock' => 20],
            ['name' => 'G.Skill Trident Z5 RGB DDR5 32GB (2x16GB) 6400MHz', 'category' => 'RAM', 'price' => 6990000, 'sale_price' => null, 'brand' => 'G.Skill', 'stock' => 30],
            ['name' => 'Corsair Vengeance DDR5 32GB (2x16GB) 6000MHz', 'category' => 'RAM', 'price' => 5490000, 'sale_price' => 4990000, 'brand' => 'Corsair', 'stock' => 40],
            ['name' => 'Kingston Fury Beast DDR5 32GB (2x16GB) 5600MHz', 'category' => 'RAM', 'price' => 4990000, 'sale_price' => 4490000, 'brand' => 'Kingston', 'stock' => 45],
            ['name' => 'Crucial DDR5 32GB (2x16GB) 5200MHz', 'category' => 'RAM', 'price' => 3990000, 'sale_price' => null, 'brand' => 'Crucial', 'stock' => 50],
            ['name' => 'G.Skill Trident Z RGB DDR4 32GB (2x16GB) 3600MHz', 'category' => 'RAM', 'price' => 3490000, 'sale_price' => 2990000, 'brand' => 'G.Skill', 'stock' => 55],
            ['name' => 'Corsair Vengeance LPX DDR4 16GB (2x8GB) 3200MHz', 'category' => 'RAM', 'price' => 1790000, 'sale_price' => 1590000, 'brand' => 'Corsair', 'stock' => 60],
            ['name' => 'Kingston Fury Beast DDR4 16GB (2x8GB) 3200MHz', 'category' => 'RAM', 'price' => 1690000, 'sale_price' => null, 'brand' => 'Kingston', 'stock' => 65],
            
            // SSD
            ['name' => 'Samsung 990 PRO 2TB NVMe Gen4', 'category' => 'SSD', 'price' => 6990000, 'sale_price' => 6290000, 'brand' => 'Samsung', 'stock' => 30],
            ['name' => 'Samsung 990 PRO 1TB NVMe Gen4', 'category' => 'SSD', 'price' => 3990000, 'sale_price' => 3490000, 'brand' => 'Samsung', 'stock' => 40],
            ['name' => 'WD Black SN850X 2TB NVMe Gen4', 'category' => 'SSD', 'price' => 5990000, 'sale_price' => null, 'brand' => 'Western Digital', 'stock' => 35],
            ['name' => 'WD Black SN850X 1TB NVMe Gen4', 'category' => 'SSD', 'price' => 3490000, 'sale_price' => 2990000, 'brand' => 'Western Digital', 'stock' => 45],
            ['name' => 'Crucial T700 2TB PCIe Gen5', 'category' => 'SSD', 'price' => 10990000, 'sale_price' => 9990000, 'brand' => 'Crucial', 'stock' => 20],
            ['name' => 'Crucial T700 1TB PCIe Gen5', 'category' => 'SSD', 'price' => 7990000, 'sale_price' => null, 'brand' => 'Crucial', 'stock' => 25],
            ['name' => 'Kingston KC3000 1TB NVMe Gen4', 'category' => 'SSD', 'price' => 2990000, 'sale_price' => 2490000, 'brand' => 'Kingston', 'stock' => 50],
            ['name' => 'Kingston NV2 1TB NVMe Gen4', 'category' => 'SSD', 'price' => 1990000, 'sale_price' => 1790000, 'brand' => 'Kingston', 'stock' => 60],
            
            // HDD
            ['name' => 'Seagate IronWolf Pro 18TB', 'category' => 'HDD', 'price' => 12990000, 'sale_price' => null, 'brand' => 'Seagate', 'stock' => 15],
            ['name' => 'WD Red Plus 8TB', 'category' => 'HDD', 'price' => 6490000, 'sale_price' => 5990000, 'brand' => 'Western Digital', 'stock' => 25],
            ['name' => 'Seagate Barracuda 4TB', 'category' => 'HDD', 'price' => 2990000, 'sale_price' => 2690000, 'brand' => 'Seagate', 'stock' => 40],
            ['name' => 'WD Blue 2TB', 'category' => 'HDD', 'price' => 1690000, 'sale_price' => null, 'brand' => 'Western Digital', 'stock' => 50],
            ['name' => 'Toshiba P300 3TB', 'category' => 'HDD', 'price' => 2290000, 'sale_price' => 1990000, 'brand' => 'Toshiba', 'stock' => 45],
            
            // PSU - Nguồn máy tính
            ['name' => 'Corsair HX1500i 1500W 80+ Platinum', 'category' => 'PSU', 'price' => 9990000, 'sale_price' => 8990000, 'brand' => 'Corsair', 'stock' => 12],
            ['name' => 'Seasonic Prime TX-1000 1000W 80+ Titanium', 'category' => 'PSU', 'price' => 7990000, 'sale_price' => null, 'brand' => 'Seasonic', 'stock' => 18],
            ['name' => 'ASUS ROG Thor 850P 850W 80+ Platinum', 'category' => 'PSU', 'price' => 6490000, 'sale_price' => 5990000, 'brand' => 'ASUS', 'stock' => 20],
            ['name' => 'Cooler Master V850 SFX Gold 850W', 'category' => 'PSU', 'price' => 4990000, 'sale_price' => null, 'brand' => 'Cooler Master', 'stock' => 25],
            ['name' => 'Thermaltake Toughpower GF1 750W 80+ Gold', 'category' => 'PSU', 'price' => 3490000, 'sale_price' => 2990000, 'brand' => 'Thermaltake', 'stock' => 30],
            ['name' => 'MSI MAG A650BN 650W 80+ Bronze', 'category' => 'PSU', 'price' => 1990000, 'sale_price' => 1790000, 'brand' => 'MSI', 'stock' => 40],
            
            // Case - Vỏ case máy tính
            ['name' => 'Lian Li O11 Dynamic EVO XL', 'category' => 'Case', 'price' => 6990000, 'sale_price' => 6490000, 'brand' => 'Lian Li', 'stock' => 15],
            ['name' => 'Corsair 5000D Airflow', 'category' => 'Case', 'price' => 4990000, 'sale_price' => null, 'brand' => 'Corsair', 'stock' => 20],
            ['name' => 'NZXT H7 Flow', 'category' => 'Case', 'price' => 3990000, 'sale_price' => 3490000, 'brand' => 'NZXT', 'stock' => 25],
            ['name' => 'Fractal Design Torrent Compact', 'category' => 'Case', 'price' => 3490000, 'sale_price' => null, 'brand' => 'Fractal Design', 'stock' => 22],
            ['name' => 'Cooler Master TD500 Mesh V2', 'category' => 'Case', 'price' => 2990000, 'sale_price' => 2690000, 'brand' => 'Cooler Master', 'stock' => 30],
            ['name' => 'Deepcool CH510 Mesh', 'category' => 'Case', 'price' => 1990000, 'sale_price' => 1790000, 'brand' => 'Deepcool', 'stock' => 35],
            
            // Cooling - Tản nhiệt
            ['name' => 'NZXT Kraken Elite 360 RGB AIO', 'category' => 'Cooling', 'price' => 7990000, 'sale_price' => 7290000, 'brand' => 'NZXT', 'stock' => 18],
            ['name' => 'Corsair iCUE H150i Elite LCD AIO', 'category' => 'Cooling', 'price' => 6990000, 'sale_price' => null, 'brand' => 'Corsair', 'stock' => 22],
            ['name' => 'Arctic Liquid Freezer II 360 AIO', 'category' => 'Cooling', 'price' => 3990000, 'sale_price' => 3490000, 'brand' => 'Arctic', 'stock' => 28],
            ['name' => 'Deepcool LT720 360 AIO', 'category' => 'Cooling', 'price' => 2990000, 'sale_price' => 2690000, 'brand' => 'Deepcool', 'stock' => 32],
            ['name' => 'Noctua NH-D15 chromax.black', 'category' => 'Cooling', 'price' => 3490000, 'sale_price' => null, 'brand' => 'Noctua', 'stock' => 25],
            ['name' => 'be quiet! Dark Rock Pro 5', 'category' => 'Cooling', 'price' => 2990000, 'sale_price' => 2790000, 'brand' => 'be quiet!', 'stock' => 30],
            ['name' => 'Thermalright Peerless Assassin 120 SE', 'category' => 'Cooling', 'price' => 990000, 'sale_price' => 890000, 'brand' => 'Thermalright', 'stock' => 50],
            
            // Monitor - Màn hình máy tính
            ['name' => 'ASUS ROG Swift PG27AQDM 27" 1440p 240Hz OLED', 'category' => 'Monitor', 'price' => 29990000, 'sale_price' => 27990000, 'brand' => 'ASUS', 'stock' => 10],
            ['name' => 'LG UltraGear 27GR95QE-B 27" 1440p 240Hz OLED', 'category' => 'Monitor', 'price' => 27990000, 'sale_price' => null, 'brand' => 'LG', 'stock' => 12],
            ['name' => 'Samsung Odyssey G8 32" 4K 240Hz', 'category' => 'Monitor', 'price' => 24990000, 'sale_price' => 22990000, 'brand' => 'Samsung', 'stock' => 15],
            ['name' => 'Dell Alienware AW3423DWF 34" Ultrawide 1440p 165Hz', 'category' => 'Monitor', 'price' => 22990000, 'sale_price' => null, 'brand' => 'Dell', 'stock' => 18],
            ['name' => 'MSI MAG274QRF-QD 27" 1440p 165Hz', 'category' => 'Monitor', 'price' => 8990000, 'sale_price' => 7990000, 'brand' => 'MSI', 'stock' => 25],
            ['name' => 'Gigabyte M27Q X 27" 1440p 240Hz', 'category' => 'Monitor', 'price' => 9990000, 'sale_price' => 8990000, 'brand' => 'Gigabyte', 'stock' => 22],
            ['name' => 'AOC 24G2 24" 1080p 144Hz', 'category' => 'Monitor', 'price' => 4990000, 'sale_price' => 4490000, 'brand' => 'AOC', 'stock' => 35],
        ];

        foreach ($products as $productData) {
            $category = $categories->firstWhere('name', $productData['category']);
            
            if (!$category) {
                continue;
            }

            Product::create([
                'category_id' => $category->id,
                'name' => $productData['name'],
                'slug' => Str::slug($productData['name']),
                'description' => 'Sản phẩm chính hãng, mới 100%, bảo hành toàn quốc',
                'price' => $productData['price'],
                'sale_price' => $productData['sale_price'],
                'sku' => strtoupper(Str::random(8)),
                'stock' => $productData['stock'],
                'brand' => $productData['brand'],
                'image' => 'https://via.placeholder.com/600x400/1a1a1a/fff?text=' . urlencode($productData['brand'] . ' ' . $productData['category']),
            ]);
        }

        $this->command->info('Created ' . count($products) . ' PC component products.');
    }
}
