<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;
use App\Models\ComponentType;
use App\Models\SpecDefinition;
use App\Models\ProductSpec;
use App\Models\ProductImage;

class SmartProductSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Truncate tables
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        ProductSpec::truncate();
        SpecDefinition::truncate();
        ProductImage::truncate();
        Product::truncate();
        ComponentType::truncate();
        Category::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Tables truncated.');

        // 2. Load JSON data
        $filterJson = File::json(base_path('filter.json'));
        $productsJson = File::json(base_path('product.json'));

        // 3. Process each Category/ComponentType
        foreach ($filterJson as $typeCode => $filters) {
            $this->command->info("Processing $typeCode...");

            // Create ComponentType
            $componentType = ComponentType::create([
                'name' => $typeCode,
                'code' => Str::slug($typeCode),
                'is_required' => true,
            ]);

            // Create Category
            $category = Category::create([
                'name' => $typeCode,
                'slug' => Str::slug($typeCode),
                'is_active' => true,
            ]);

            // Create SpecDefinitions
            $specDefs = [];
            $sortOrder = 0;
            foreach ($filters as $filter) {
                $specCode = $filter['id'];
                
                $metaData = [
                    'field' => $filter['field'] ?? null,
                ];

                if (isset($filter['min'])) $metaData['min'] = $filter['min'];
                if (isset($filter['max'])) $metaData['max'] = $filter['max'];
                if (isset($filter['step'])) $metaData['step'] = $filter['step'];

                $specDefs[$specCode] = SpecDefinition::create([
                    'component_type_id' => $componentType->id,
                    'name' => $filter['label'],
                    'code' => $specCode,
                    'input_type' => $filter['type'], // checkbox, range, switch
                    'options' => isset($filter['options']) ? json_encode($filter['options']) : null,
                    'meta_data' => json_encode($metaData),
                    'is_filterable' => true,
                    'sort_order' => $sortOrder++,
                ]);
            }

            // Get existing products for this type
            $existingProducts = $productsJson[$typeCode] ?? [];
            
            // Insert Real Products
            foreach ($existingProducts as $pData) {
                $product = $this->createProduct($pData, $category, $componentType);
                
                // Add specs based on SpecDefinitions
                foreach ($specDefs as $specCode => $specDef) {
                    $metaData = json_decode($specDef->meta_data, true);
                    $field = $metaData['field'] ?? null;

                    if ($field) {
                        // Use data_get to retrieve value using dot notation (e.g. "specs.cores")
                        $value = data_get($pData, $field);

                        if ($value !== null) {
                            // Handle boolean values for switch
                            if (is_bool($value)) {
                                $value = $value ? '1' : '0';
                            }
                            // Handle array values (if any, though product.json seems to have scalar values mostly, except memory_support)
                            if (is_array($value)) {
                                $value = implode(', ', $value);
                            }

                            ProductSpec::create([
                                'product_id' => $product->id,
                                'spec_definition_id' => $specDef->id,
                                'value' => (string) $value,
                            ]);
                        }
                    }
                }
            }
        }
    }

    private function createProduct($data, $category, $componentType)
    {
        $price = ($data['price_usd'] ?? 100) * 25000; // Convert USD to VND
        
        return Product::create([
            'name' => $data['name'] ?? (($data['brand'] ?? '') . ' ' . ($data['model'] ?? 'Unknown')),
            'slug' => Str::slug(($data['name'] ?? 'product') . '-' . Str::random(6)),
            'sku' => strtoupper(Str::random(8)),
            'description' => "Sản phẩm " . ($data['name'] ?? 'chất lượng cao'),
            'price' => $price,
            'sale_price' => $price * 0.9, // 10% off
            'stock' => 100,
            'category_id' => $category->id,
            'component_type_id' => $componentType->id,
            'is_active' => true,
            'brand_id' => null, // We could create brands table and link it, but for now keep it simple
        ]);
    }
}
