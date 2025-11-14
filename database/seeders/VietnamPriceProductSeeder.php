<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class VietnamPriceProductSeeder extends Seeder
{
    public function run()
    {
        // Load product data from JSON
        $jsonPath = database_path('../product_data.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error('product_data.json not found!');
            return;
        }

        $productsData = json_decode(File::get($jsonPath), true);
        $categories = Category::all()->keyBy('name');

        $this->command->info('Importing ' . count($productsData) . ' products with Vietnamese pricing...');
        $bar = $this->command->getOutput()->createProgressBar(count($productsData));

        foreach ($productsData as $data) {
            $category = $categories->get($data['category']);
            
            if (!$category) {
                $this->command->warn("Category '{$data['category']}' not found for {$data['name']}");
                continue;
            }

            // Check if product already exists
            $existingProduct = Product::where('sku', $data['sku'])->first();
            
            if ($existingProduct) {
                // Update existing product
                $existingProduct->update([
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'brand' => $data['brand'],
                    'price' => $data['price_vnd'],
                    'sale_price' => $this->calculateSalePrice($data['price_vnd'], $data['category']),
                    'stock' => $data['stock'],
                    'description' => $this->generateDescription($data),
                    'image' => $this->getProductImage($data),
                ]);
                $this->command->info(" Updated: {$data['name']}");
            } else {
                // Create new product
                Product::create([
                    'category_id' => $category->id,
                    'name' => $data['name'],
                    'slug' => Str::slug($data['name']),
                    'brand' => $data['brand'],
                    'price' => $data['price_vnd'],
                    'sale_price' => $this->calculateSalePrice($data['price_vnd'], $data['category']),
                    'stock' => $data['stock'],
                    'sku' => $data['sku'],
                    'description' => $this->generateDescription($data),
                    'image' => $this->getProductImage($data),
                ]);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->command->newLine();
        $this->command->info('✅ Successfully imported all products with Vietnamese pricing!');
    }

    private function calculateSalePrice($price, $category)
    {
        // Apply category-based discounts (10-15% off)
        $discountRates = [
            'CPU' => 0.12,      // 12% off
            'GPU' => 0.10,      // 10% off
            'RAM' => 0.15,      // 15% off
            'SSD' => 0.12,      // 12% off
            'HDD' => 0.10,      // 10% off
            'PSU' => 0.08,      // 8% off
            'Case' => 0.10,     // 10% off
            'Cooling' => 0.12,  // 12% off
            'Mainboard' => 0.10, // 10% off
            'Monitor' => 0.08,  // 8% off
        ];

        $discount = $discountRates[$category] ?? 0.10;
        return (int)($price * (1 - $discount));
    }

    private function getProductImage($product)
    {
        // Generate better placeholder images based on product category
        $keywords = [
            'CPU' => 'computer_processor',
            'GPU' => 'graphics_card_nvidia',
            'Mainboard' => 'computer_motherboard',
            'RAM' => 'computer_memory_ddr5',
            'SSD' => 'nvme_ssd_storage',
            'HDD' => 'hard_drive_disk',
            'PSU' => 'power_supply_unit',
            'Case' => 'pc_case_tower',
            'Cooling' => 'cpu_cooler_heatsink',
            'Monitor' => 'gaming_monitor_display',
        ];

        $keyword = $keywords[$product['category']] ?? 'computer_parts';
        $seed = crc32($product['sku']) % 1000;
        
        // Use unsplash API for high-quality images
        return "https://images.unsplash.com/photo-{$seed}?w=500&h=500&q=80&fit=crop";
    }

    private function generateDescription($product)
    {
        $brand = $product['brand'];
        $category = $product['category'];
        $name = $product['name'];

        $descriptions = [
            'CPU' => "High-performance processor from {$brand}. {$name} delivers excellent performance for gaming, content creation, and professional workloads.",
            'GPU' => "Powerful graphics card from {$brand}. {$name} with excellent VRAM capacity and cooling for gaming and rendering.",
            'Mainboard' => "Premium motherboard from {$brand}. {$name} features robust power delivery and extensive connectivity options.",
            'RAM' => "High-speed memory from {$brand}. {$name} optimized for gaming and productivity workloads.",
            'SSD' => "Ultra-fast NVMe SSD from {$brand}. {$name} with excellent sequential read/write speeds.",
            'HDD' => "Reliable storage drive from {$brand}. {$name} ideal for backup and long-term data storage.",
            'PSU' => "High-efficiency power supply from {$brand}. {$name} with excellent stability and protection features.",
            'Case' => "Well-designed PC case from {$brand}. {$name} with excellent airflow and cable management.",
            'Cooling' => "Effective cooling solution from {$brand}. {$name} with excellent thermal performance.",
            'Monitor' => "High-quality display from {$brand}. {$name} with vibrant colors and excellent refresh rate.",
        ];

        return $descriptions[$category] ?? "Premium computer component from {$brand}.";
    }
}
