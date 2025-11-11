<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CheckoutControllerTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->verified()->create();
    }

    /** @test */
    public function unauthenticated_user_cannot_checkout()
    {
        $response = $this->get(route('checkout.show'));

        $response->assertRedirect(route('login'));
    }

    /** @test */
    public function unverified_user_cannot_checkout()
    {
        $unverified = User::factory()->create();

        $response = $this->actingAs($unverified)->get(route('checkout.show'));

        $response->assertRedirect();
    }

    /** @test */
    public function verified_user_can_view_checkout()
    {
        $response = $this->actingAs($this->user)->get(route('checkout.show'));

        $response->assertStatus(200);
    }

    /** @test */
    public function can_create_order_from_cart()
    {
        $product = Product::factory()->create(['price' => 1000000]);
        $cart = $this->user->getOrCreateActiveCart();
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 2,
        ]);

        $address = $this->user->addresses()->create([
            'full_name' => 'John Doe',
            'street_address' => '123 Main St',
            'city' => 'Hanoi',
            'province' => 'Hanoi',
            'postal_code' => '10000',
            'phone' => '0123456789',
        ]);

        $response = $this->actingAs($this->user)->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'cod',
        ]);

        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'payment_method' => 'cod',
        ]);
    }

    /** @test */
    public function order_total_calculated_correctly()
    {
        $product1 = Product::factory()->create(['price' => 1000000]);
        $product2 = Product::factory()->create(['price' => 2000000]);
        
        $cart = $this->user->getOrCreateActiveCart();
        $cart->items()->createMany([
            ['product_id' => $product1->id, 'quantity' => 2],
            ['product_id' => $product2->id, 'quantity' => 1],
        ]);

        $address = $this->user->addresses()->create([
            'full_name' => 'John Doe',
            'street_address' => '123 Main St',
            'city' => 'Hanoi',
            'province' => 'Hanoi',
            'postal_code' => '10000',
            'phone' => '0123456789',
        ]);

        $response = $this->actingAs($this->user)->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'cod',
        ]);

        // Total should be (1000000 * 2) + (2000000 * 1) = 4000000
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'total_amount' => 4000000,
        ]);
    }

    /** @test */
    public function cart_cleared_after_order()
    {
        $product = Product::factory()->create();
        $cart = $this->user->getOrCreateActiveCart();
        $cart->items()->create([
            'product_id' => $product->id,
            'quantity' => 1,
        ]);

        $address = $this->user->addresses()->create([
            'full_name' => 'John Doe',
            'street_address' => '123 Main St',
            'city' => 'Hanoi',
            'province' => 'Hanoi',
            'postal_code' => '10000',
            'phone' => '0123456789',
        ]);

        $this->actingAs($this->user)->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'cod',
        ]);

        $this->assertEquals(0, $cart->items()->count());
    }

    /** @test */
    public function cannot_checkout_empty_cart()
    {
        $cart = $this->user->getOrCreateActiveCart();

        $address = $this->user->addresses()->create([
            'full_name' => 'John Doe',
            'street_address' => '123 Main St',
            'city' => 'Hanoi',
            'province' => 'Hanoi',
            'postal_code' => '10000',
            'phone' => '0123456789',
        ]);

        $response = $this->actingAs($this->user)->post(route('checkout.store'), [
            'address_id' => $address->id,
            'payment_method' => 'cod',
        ]);

        $response->assertRedirect();
    }
}
