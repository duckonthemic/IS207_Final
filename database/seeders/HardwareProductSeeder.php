<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\ComponentType;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class HardwareProductSeeder extends Seeder
{
    private $categoryMapping = [
        'CPU' => 'CPU - Bộ vi xử lý',
        'GPU' => 'VGA - Card màn hình',
        'RAM' => 'RAM - Bộ nhớ trong',
        'SSD' => 'SSD - Ổ cứng SSD',
        'Mainboard' => 'Mainboard - Bo mạch chủ',
    ];

    private $componentTypeMapping = [
        'CPU' => 'cpu',
        'GPU' => 'gpu',
        'RAM' => 'ram',
        'SSD' => 'ssd',
        'Mainboard' => 'mainboard',
    ];

    public function run(): void
    {
        $this->command->info('🔄 Importing hardware products from detailed JSON...');

        $jsonPath = base_path('hardware_products_detailed.json');
        
        if (!File::exists($jsonPath)) {
            $this->command->error('❌ File hardware_products_detailed.json not found!');
            return;
        }

        $jsonContent = File::get($jsonPath);
        $data = json_decode($jsonContent, true);

        if (!$data) {
            $this->command->error('❌ Failed to parse JSON file!');
            return;
        }

        $stats = [
            'total' => 0,
            'categories' => [],
            'value' => 0,
        ];

        $totalProducts = array_sum(array_map('count', $data));
        $bar = $this->command->getOutput()->createProgressBar($totalProducts);
        $bar->start();

        foreach ($data as $categoryKey => $products) {
            $this->processCategory($categoryKey, $products, $stats, $bar);
        }

        $bar->finish();
        $this->command->newLine(2);
        $this->command->info('✅ Successfully imported all hardware products!');
        $this->command->info("📊 Summary:");
        $this->command->info("   Total Products: {$stats['total']}");
        $this->command->info("   Categories: " . count($stats['categories']));
        foreach ($stats['categories'] as $cat => $count) {
            $this->command->info("   - {$cat}: {$count} products");
        }
    }

    private function processCategory(string $categoryKey, array $products, array &$stats, $bar): void
    {
        // Get or create category
        $categoryName = $this->categoryMapping[$categoryKey] ?? $categoryKey;
        $category = Category::firstOrCreate(
            ['name' => $categoryName],
            [
                'slug' => Str::slug($categoryName),
                'description' => "Danh mục {$categoryName}",
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        // Get component type
        $componentTypeCode = $this->componentTypeMapping[$categoryKey] ?? strtolower($categoryKey);
        $componentType = ComponentType::where('code', $componentTypeCode)->first();

        $stats['categories'][$categoryName] = 0;

        foreach ($products as $productData) {
            $this->createProduct($productData, $category, $componentType, $stats);
            $bar->advance();
        }
    }

    private function createProduct(array $data, Category $category, ?ComponentType $componentType, array &$stats): void
    {
        // Generate Vietnamese price (USD * 25,000)
        $priceVND = round($data['price_usd'] * 25000, -3); // Round to thousands
        
        // Create SKU
        $sku = strtoupper(substr($data['brand'], 0, 3)) . '-' . 
               strtoupper(str_replace(' ', '', substr($data['model'], 0, 8))) . '-' . 
               substr(uniqid(), -4);

        // Create description
        $description = $this->generateDescription($data);

        // Create product
        $product = Product::create([
            'name' => "{$data['brand']} {$data['model']}",
            'slug' => Str::slug("{$data['brand']} {$data['model']}") . '-' . substr(uniqid(), -4),
            'sku' => $sku,
            'description' => $description,
            'price' => $priceVND,
            'sale_price' => null,
            'stock' => rand(5, 50),
            'category_id' => $category->id,
            'component_type_id' => $componentType?->id,
            'is_active' => true,
            'is_featured' => rand(0, 100) < 20, // 20% featured
        ]);

        // Create placeholder image
        ProductImage::create([
            'product_id' => $product->id,
            'url' => $this->getPlaceholderImage($category->name),
            'is_primary' => true,
        ]);

        $stats['total']++;
        $stats['categories'][$category->name] = ($stats['categories'][$category->name] ?? 0) + 1;
        $stats['value'] += $priceVND;
    }

    private function generateDescription(array $data): string
    {
        $specs = $data['specs'] ?? [];
        $parts = ["{$data['brand']} {$data['model']} - Năm phát hành {$data['release_year']}"];

        // Add key specs based on product type
        if (isset($specs['cores'])) {
            $parts[] = "{$specs['cores']} nhân, {$specs['threads']} luồng";
        }
        if (isset($specs['p_core_boost_ghz'])) {
            $parts[] = "Tốc độ tối đa {$specs['p_core_boost_ghz']} GHz";
        }
        if (isset($specs['memory_size_gb'])) {
            $parts[] = "{$specs['memory_size_gb']}GB {$specs['memory_type']}";
        }
        if (isset($specs['capacity_gb'])) {
            $parts[] = "Dung lượng {$specs['capacity_gb']}GB";
        }
        if (isset($specs['speed_mhz'])) {
            $parts[] = "{$specs['speed_mhz']}MHz";
        }
        if (isset($specs['chipset'])) {
            $parts[] = "Chipset {$specs['chipset']}";
        }

        return implode('. ', $parts);
    }

    private function getPlaceholderImage(string $categoryName): string
    {
        $imageMap = [
            'CPU - Bộ vi xử lý' => 'https://via.placeholder.com/800x800/1a1a1a/ffffff?text=CPU',
            'VGA - Card màn hình' => 'https://via.placeholder.com/800x800/1a1a1a/ffffff?text=GPU',
            'RAM - Bộ nhớ trong' => 'https://via.placeholder.com/800x800/1a1a1a/ffffff?text=RAM',
            'SSD - Ổ cứng SSD' => 'https://via.placeholder.com/800x800/1a1a1a/ffffff?text=SSD',
            'Mainboard - Bo mạch chủ' => 'https://via.placeholder.com/800x800/1a1a1a/ffffff?text=Mainboard',
        ];

        return $imageMap[$categoryName] ?? 'https://via.placeholder.com/800x800/1a1a1a/ffffff?text=Product';
    }
}
