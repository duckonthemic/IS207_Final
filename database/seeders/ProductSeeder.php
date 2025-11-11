<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Branch;
use App\Models\Inventory;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Create 50 products
        Product::factory(50)
            ->sequence(function ($seq) {
                $categories = Category::pluck('id')->toArray();
                $manufacturers = Manufacturer::pluck('id')->toArray();

                return [
                    'category_id' => $categories[array_rand($categories)],
                    'manufacturer_id' => $manufacturers[array_rand($manufacturers)],
                ];
            })
            ->create()
            ->each(function (Product $product) {
                // Add inventory for each branch
                $branches = Branch::all();
                foreach ($branches as $branch) {
                    Inventory::create([
                        'product_id' => $product->id,
                        'branch_id' => $branch->id,
                        'qty' => rand(10, 100),
                    ]);
                }

                // Add product images
                if (rand(0, 1)) {
                    $product->images()->create([
                        'url' => 'https://via.placeholder.com/400?text=' . urlencode($product->name),
                        'is_primary' => true,
                        'sort_order' => 0,
                    ]);
                }

                // Add specs
                $specs = [
                    'color' => ['Đen', 'Trắng', 'Bạc', 'Xanh'][rand(0, 3)],
                    'warranty' => [12, 24, 36][rand(0, 2)] . ' tháng',
                    'origin' => ['Trung Quốc', 'Đài Loan', 'Hàn Quốc', 'Nhật Bản'][rand(0, 3)],
                ];

                foreach ($specs as $key => $value) {
                    $product->specs()->create([
                        'spec_key' => $key,
                        'spec_value' => $value,
                    ]);
                }
            });
    }
}
