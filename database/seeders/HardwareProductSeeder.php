<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\ComponentType;
use App\Models\Product;
use App\Models\ProductSpec;
use App\Models\SpecDefinition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class HardwareProductSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = base_path('hardware_products_detailed.json');
        if (!File::exists($jsonPath)) {
            $this->command->error("File not found: $jsonPath");
            return;
        }

        $data = json_decode(File::get($jsonPath), true);

        foreach ($data as $categoryName => $products) {
            $this->command->info("Processing category: $categoryName");

            // 1. Create or Get Category
            $category = Category::firstOrCreate(
                ['slug' => Str::slug($categoryName)],
                ['name' => $categoryName, 'description' => "All $categoryName products"]
            );

            // 2. Create or Get ComponentType (assuming 1-to-1 mapping for simplicity)
            $componentType = ComponentType::firstOrCreate(
                ['code' => Str::slug($categoryName)],
                ['name' => $categoryName]
            );

            foreach ($products as $productData) {
                // 3. Create Product
                $productName = $productData['brand'] . ' ' . $productData['model'];
                $priceVnd = $productData['price_usd'] * 25000; // Approximate exchange rate

                $product = Product::updateOrCreate(
                    ['slug' => Str::slug($productName)], // Using slug for uniqueness
                    [
                        'name' => $productName,
                        'sku' => Str::slug($productName), // SKU same as slug for now
                        'category_id' => $category->id,
                        'description' => $productData['specs']['segment'] ?? '',
                        'price' => $priceVnd,
                        'sale_price' => null,
                        'stock' => 100, // Default stock
                        // 'brand_id' => null, // We could map brands if we had the table populated
                        // 'component_type_id' => $componentType->id, // Check if product has this column
                    ]
                );
                
                // Check if product has component_type_id column, if so update it
                // (Assuming it might be added in a migration)
                // Actually, looking at migration 2025_11_14_083454_update_products_add_brand_component_fields.php
                // it seems it was added.
                 $product->component_type_id = $componentType->id;
                 $product->save();


                // 4. Process Specs
                if (isset($productData['specs'])) {
                    foreach ($productData['specs'] as $specKey => $specValue) {
                        // Create SpecDefinition if not exists
                        $specDef = SpecDefinition::firstOrCreate(
                            ['code' => Str::slug($categoryName . '_' . $specKey)],
                            [
                                'name' => Str::title(str_replace('_', ' ', $specKey)),
                                'component_type_id' => $componentType->id,
                                'input_type' => 'text',
                            ]
                        );

                        // Create ProductSpec
                        ProductSpec::updateOrCreate(
                            [
                                'product_id' => $product->id,
                                'spec_definition_id' => $specDef->id,
                            ],
                            [
                                'value' => is_array($specValue) ? json_encode($specValue) : (string) $specValue,
                            ]
                        );
                    }
                }
            }
        }
    }
}
