<?php

namespace Tests\Unit\Models;

use App\Models\Cart;
use App\Models\User;
use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CartTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
    }

    /** @test */
    public function can_calculate_cart_total()
    {
        $cart = Cart::factory()->for($this->user)->create();
        $product1 = Product::factory()->create(['price' => 1000000]);
        $product2 = Product::factory()->create(['price' => 2000000]);

        $cart->items()->createMany([
            ['product_id' => $product1->id, 'quantity' => 2],
            ['product_id' => $product2->id, 'quantity' => 1],
        ]);

        $total = $cart->getTotal();
        $this->assertEquals(4000000, $total); // (1000000 * 2) + (2000000 * 1)
    }

    /** @test */
    public function can_get_item_count()
    {
        $cart = Cart::factory()->for($this->user)->create();
        $product = Product::factory()->create();

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 5,
        ]);

        $this->assertEquals(5, $cart->getItemCount());
    }

    /** @test */
    public function can_get_or_create_active_cart_for_user()
    {
        $cart = $this->user->getOrCreateActiveCart();

        $this->assertNotNull($cart);
        $this->assertEquals($this->user->id, $cart->user_id);
        $this->assertTrue($cart->is_active);
    }

    /** @test */
    public function returns_existing_active_cart()
    {
        $cart1 = Cart::factory()->for($this->user)->create(['is_active' => true]);
        $cart2 = $this->user->getOrCreateActiveCart();

        $this->assertEquals($cart1->id, $cart2->id);
    }

    /** @test */
    public function can_clear_cart_items()
    {
        $cart = Cart::factory()->for($this->user)->create();
        $product = Product::factory()->create();

        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 3,
        ]);

        $this->assertEquals(1, $cart->items()->count());

        $cart->items()->delete();

        $this->assertEquals(0, $cart->items()->count());
    }

    /** @test */
    public function can_deactivate_cart()
    {
        $cart = Cart::factory()->for($this->user)->create(['is_active' => true]);

        $cart->update(['is_active' => false]);

        $this->assertFalse($cart->is_active);
    }

    /** @test */
    public function active_scope_returns_only_active_carts()
    {
        $active = Cart::factory()->for($this->user)->create(['is_active' => true]);
        $inactive = Cart::factory()->for($this->user)->create(['is_active' => false]);

        $result = Cart::active()->get();

        $this->assertTrue($result->contains($active));
        $this->assertFalse($result->contains($inactive));
    }
}
