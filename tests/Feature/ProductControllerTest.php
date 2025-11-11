<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function can_view_product_listing()
    {
        Product::factory()->count(5)->create();

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
        $response->assertViewHas('products');
    }

    /** @test */
    public function can_search_products()
    {
        Product::factory()->create(['name' => 'Intel Core i7']);
        Product::factory()->create(['name' => 'AMD Ryzen 5']);

        $response = $this->get(route('products.index', ['search' => 'Intel']));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_filter_products_by_category()
    {
        $category = Category::factory()->create();
        Product::factory()->create(['category_id' => $category->id]);
        Product::factory()->create(['category_id' => $category->id]);

        $response = $this->get(route('products.index', ['category' => $category->id]));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_view_product_detail()
    {
        $product = Product::factory()->create();

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
        $response->assertViewHas('product');
    }

    /** @test */
    public function product_detail_shows_related_products()
    {
        $category = Category::factory()->create();
        $product = Product::factory()->create(['category_id' => $category->id]);
        Product::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->get(route('products.show', $product));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_filter_products_by_price_range()
    {
        Product::factory()->create(['price' => 5000000]);
        Product::factory()->create(['price' => 15000000]);

        $response = $this->get(route('products.index', [
            'min_price' => 8000000,
            'max_price' => 12000000,
        ]));

        $response->assertStatus(200);
    }

    /** @test */
    public function inactive_products_not_shown_in_listing()
    {
        Product::factory()->create(['is_active' => true]);
        Product::factory()->create(['is_active' => false]);

        $response = $this->get(route('products.index'));

        $response->assertStatus(200);
    }
}
