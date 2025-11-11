<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    protected $model = Category::class;

    public function definition(): array
    {
        $name = $this->faker->unique()->word();
        return [
            'parent_id' => null,
            'name' => ucfirst($name),
            'slug' => str($name)->slug(),
            'depth' => 0,
            'description' => $this->faker->sentence(),
            'status' => 1,
        ];
    }

    public function child($parentId = null): self
    {
        return $this->state(function (array $attributes) use ($parentId) {
            return [
                'parent_id' => $parentId ?? Category::factory(),
                'depth' => 1,
            ];
        });
    }
}
