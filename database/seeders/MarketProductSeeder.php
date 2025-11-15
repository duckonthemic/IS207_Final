<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class MarketProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Read market data
        $json_file = base_path('market_products.json');
        if (!file_exists($json_file)) {
            $this->command->error("market_products.json not found! Run: python market_data_collector.py");
            return;
        }

        $data = json_decode(file_get_contents($json_file), true);
        $products = $data['products'] ?? [];

        if (empty($products)) {
            $this->command->error("No products found in market_products.json");
            return;
        }

        $this->command->info("Importing " . count($products) . " products from market data...");

        $progress = $this->command->getOutput()->createProgressBar(count($products));
        $progress->start();

        foreach ($products as $item) {
            try {
                // Get or create category
                $category = Category::where('name', $item['category'])->first();
                if (!$category) {
                    $category = Category::create([
                        'name' => $item['category'],
                        'slug' => Str::slug($item['category']),
                        'description' => $item['category'],
                        'status' => 1,
                    ]);
                }

                // Create or update product
                $product = Product::updateOrCreate(
                    ['sku' => $item['sku']],
                    [
                        'name' => $item['name'],
                        'slug' => Str::slug($item['name']),
                        'description' => $item['specs'] ?? 'High-performance PC component',
                        'category_id' => $category->id,
                        'price' => $item['price'],
                        'sale_price' => $item['sale_price'],
                        'stock' => $item['stock'],
                        'is_active' => true,
                        'is_featured' => rand(0, 100) > 70,
                    ]
                );

                // Add product image if not exists
                if (!$product->images()->exists() && isset($item['image'])) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'url' => $item['image'],
                        'is_primary' => true,
                    ]);
                }

                $progress->advance();
            } catch (\Exception $e) {
                $this->command->warn("Error importing {$item['sku']}: " . $e->getMessage());
                $progress->advance();
            }
        }

        $progress->finish();
        
        $this->command->newLine();
        $this->command->info("✅ Successfully imported all market products!");
        
        // Print summary
        $total = Product::count();
        $categories = Category::count();
        $total_value = Product::sum(\DB::raw('sale_price * stock'));
        
        $this->command->info("📊 Summary:");
        $this->command->info("   Total Products: {$total}");
        $this->command->info("   Categories: {$categories}");
        $this->command->info("   Inventory Value: " . number_format($total_value, 0) . "₫");
    }
}
