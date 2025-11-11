<?php

namespace Tests\Unit\Models;

use App\Models\Order;
use App\Models\User;
use App\Models\Promotion;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_calculate_total_discount()
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create(['total_discount' => 500000]);

        $this->assertEquals(500000, $order->total_discount);
    }

    /** @test */
    public function can_retrieve_paid_orders()
    {
        $paid = Order::factory()->create(['payment_status' => 'paid']);
        $pending = Order::factory()->create(['payment_status' => 'pending']);

        $result = Order::paid()->get();

        $this->assertTrue($result->contains($paid));
        $this->assertFalse($result->contains($pending));
    }

    /** @test */
    public function can_retrieve_delivered_orders()
    {
        $delivered = Order::factory()->create(['status' => 'delivered']);
        $pending = Order::factory()->create(['status' => 'pending']);

        $result = Order::delivered()->get();

        $this->assertTrue($result->contains($delivered));
        $this->assertFalse($result->contains($pending));
    }

    /** @test */
    public function order_has_unique_order_code()
    {
        $order1 = Order::factory()->create();
        $order2 = Order::factory()->create();

        $this->assertNotEquals($order1->order_code, $order2->order_code);
    }

    /** @test */
    public function can_get_order_total_amount()
    {
        $order = Order::factory()->create([
            'total_amount' => 15000000,
        ]);

        $this->assertEquals(15000000, $order->total_amount);
    }

    /** @test */
    public function can_retrieve_order_with_items()
    {
        $order = Order::factory()
            ->has(Order\OrderItem::factory()->count(3))
            ->create();

        $loaded = Order::with('items')->find($order->id);

        $this->assertEquals(3, $loaded->items->count());
    }

    /** @test */
    public function can_filter_orders_by_payment_status()
    {
        Order::factory()->count(3)->create(['payment_status' => 'paid']);
        Order::factory()->count(2)->create(['payment_status' => 'pending']);

        $paid = Order::where('payment_status', 'paid')->get();

        $this->assertEquals(3, $paid->count());
    }

    /** @test */
    public function order_belongs_to_user()
    {
        $user = User::factory()->create();
        $order = Order::factory()->for($user)->create();

        $this->assertEquals($user->id, $order->user->id);
    }
}
