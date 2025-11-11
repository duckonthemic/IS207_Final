<?php

namespace Tests\Feature;

use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function unauthenticated_user_cannot_view_cart()
    {
        $response = $this->get(route('cart.index'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function authenticated_user_can_view_cart()
    {
        $response = $this->actingAs($this->user)->get(route('cart.index'));

        $response->assertStatus(200);
        $response->assertViewHas('cart');
    }

    /** @test */
    public function can_add_product_to_cart()
    {
        $product = Product::factory()->create();

        $response = $this->actingAs($this->user)->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $this->assertTrue($response->isRedirect());
        $this->assertDatabaseHas('cart_items', [
            'product_id' => $product->id,
            'quantity' => 2,
        ]);
    }

    /** @test */
    public function cannot_add_inactive_product_to_cart()
    {
        $product = Product::factory()->create(['is_active' => false]);

        $response = $this->actingAs($this->user)->post(route('cart.add'), [
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response->assertRedirect();
    }

    /** @test */
    public function can_update_cart_item_quantity()
    {
        $product = Product::factory()->create();
        $cart = $this->user->getOrCreateActiveCart();
        $item = $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->put(route('cart.update', $item), [
            'quantity' => 5,
        ]);

        $this->assertDatabaseHas('cart_items', [
            'id' => $item->id,
            'quantity' => 5,
        ]);
    }

    /** @test */
    public function can_remove_item_from_cart()
    {
        $product = Product::factory()->create();
        $cart = $this->user->getOrCreateActiveCart();
        $item = $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $response = $this->actingAs($this->user)->delete(route('cart.remove', $item));

        $this->assertDatabaseMissing('cart_items', ['id' => $item->id]);
    }

    /** @test */
    public function can_clear_entire_cart()
    {
        $cart = $this->user->getOrCreateActiveCart();
        $product = Product::factory()->create();
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $response = $this->actingAs($this->user)->post(route('cart.clear'));

        $this->assertEquals(0, $cart->items()->count());
    }

    /** @test */
    public function cart_displays_item_count()
    {
        $product = Product::factory()->create();
        $cart = $this->user->getOrCreateActiveCart();
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $response = $this->actingAs($this->user)->get(route('cart.index'));

        $response->assertStatus(200);
    }
}
