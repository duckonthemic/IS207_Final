<?php

namespace Tests\Unit\Models;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_retrieve_active_products()
    {
        $active = Product::factory()->create(['is_active' => true]);
        $inactive = Product::factory()->create(['is_active' => false]);

        $result = Product::active()->get();

        $this->assertTrue($result->contains($active));
        $this->assertFalse($result->contains($inactive));
    }

    /** @test */
    public function can_search_products_by_name()
    {
        Product::factory()->create(['name' => 'Intel Core i7']);
        Product::factory()->create(['name' => 'AMD Ryzen 5']);

        $result = Product::search('Intel')->get();

        $this->assertEquals(1, $result->count());
        $this->assertEquals('Intel Core i7', $result->first()->name);
    }

    /** @test */
    public function can_filter_products_by_category()
    {
        $category1 = Category::factory()->create();
        $category2 = Category::factory()->create();
        
        $product1 = Product::factory()->create(['category_id' => $category1->id]);
        $product2 = Product::factory()->create(['category_id' => $category2->id]);

        $result = Product::byCategory($category1->id)->get();

        $this->assertTrue($result->contains($product1));
        $this->assertFalse($result->contains($product2));
    }

    /** @test */
    public function can_filter_products_by_price_range()
    {
        Product::factory()->create(['price' => 5000000]);
        Product::factory()->create(['price' => 10000000]);
        Product::factory()->create(['price' => 15000000]);

        $result = Product::whereBetween('price', [8000000, 12000000])->get();

        $this->assertEquals(1, $result->count());
        $this->assertEquals(10000000, $result->first()->price);
    }

    /** @test */
    public function can_get_product_total_stock()
    {
        $product = Product::factory()->create();
        $product->inventory()->createMany([
            ['branch_id' => 1, 'quantity' => 10],
            ['branch_id' => 2, 'quantity' => 20],
            ['branch_id' => 3, 'quantity' => 15],
        ]);

        $this->assertEquals(45, $product->getTotalStock());
    }

    /** @test */
    public function can_apply_sale_price_discount()
    {
        $product = Product::factory()->create([
            'price' => 10000000,
            'sale_price' => 8000000
        ]);

        $discount = $product->price - $product->sale_price;
        $this->assertEquals(2000000, $discount);
    }

    /** @test */
    public function can_retrieve_product_with_relationships()
    {
        $product = Product::factory()
            ->has(Product\ProductImage::factory()->count(3))
            ->create();

        $loaded = Product::with('images')->find($product->id);

        $this->assertEquals(3, $loaded->images->count());
    }
}
