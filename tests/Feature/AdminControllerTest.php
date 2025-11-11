<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create(['role' => 'admin']);
        $this->user = User::factory()->create(['role' => 'user']);
    }

    /** @test */
    public function unauthenticated_user_cannot_access_admin_dashboard()
    {
        $response = $this->get(route('admin.dashboard'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function non_admin_user_cannot_access_admin_dashboard()
    {
        $response = $this->actingAs($this->user)->get(route('admin.dashboard'));

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_access_dashboard()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

        $response->assertStatus(200);
        $response->assertViewHas('orders');
        $response->assertViewHas('topProducts');
    }

    /** @test */
    public function admin_can_view_products_list()
    {
        Product::factory()->count(5)->create();

        $response = $this->actingAs($this->admin)->get(route('admin.products.index'));

        $response->assertStatus(200);
        $response->assertViewHas('products');
    }

    /** @test */
    public function admin_can_create_product()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->post(route('admin.products.store'), [
            'name' => 'Intel Core i7',
            'sku' => 'INTEL-I7-001',
            'category_id' => $category->id,
            'price' => 20000000,
            'description' => 'High-performance processor',
        ]);

        $this->assertDatabaseHas('products', [
            'name' => 'Intel Core i7',
            'sku' => 'INTEL-I7-001',
        ]);
    }

    /** @test */
    public function non_admin_cannot_create_product()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->user)->post(route('admin.products.store'), [
            'name' => 'Intel Core i7',
            'sku' => 'INTEL-I7-001',
            'category_id' => $category->id,
            'price' => 20000000,
        ]);

        $response->assertForbidden();
    }

    /** @test */
    public function admin_can_update_product()
    {
        $product = Product::factory()->create();
        $category = Category::factory()->create();

        $response = $this->actingAs($this->admin)->patch(route('admin.products.update', $product), [
            'name' => 'Updated Name',
            'sku' => $product->sku,
            'category_id' => $category->id,
            'price' => $product->price,
        ]);

        $this->assertDatabaseHas('products', [
            'id' => $product->id,
            'name' => 'Updated Name',
        ]);
    }

    /** @test */
    public function admin_can_delete_product()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->admin)->delete(route('admin.products.destroy', $product));

        $this->assertDatabaseMissing('products', ['id' => $product->id]);
    }

    /** @test */
    public function admin_can_view_orders()
    {
        $response = $this->actingAs($this->admin)->get(route('admin.orders.index'));

        $response->assertStatus(200);
        $response->assertViewHas('orders');
    }

    /** @test */
    public function non_admin_cannot_manage_products()
    {
        $category = Category::factory()->create();

        $response = $this->actingAs($this->user)->get(route('admin.products.index'));

        $response->assertForbidden();
    }
}
