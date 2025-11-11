<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Manufacturer;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {
        $name = $this->faker->words(3, true);
        return [
            'category_id' => Category::factory(),
            'manufacturer_id' => Manufacturer::factory(),
            'name' => ucfirst($name),
            'slug' => str($name)->slug(),
            'description' => $this->faker->sentence(10),
            'price' => $this->faker->numberBetween(1000000, 50000000),
            'sale_price' => $this->faker->optional(0.3)->numberBetween(800000, 45000000),
            'sku' => $this->faker->unique()->bothify('SKU-#####?'),
            'status' => 1,
        ];
    }
}
