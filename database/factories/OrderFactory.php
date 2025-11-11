<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'order_code' => 'ORD-' . $this->faker->unique()->numerify('######'),
            'payment_status' => 'pending',
            'status' => 'pending',
            'total' => $this->faker->numberBetween(100000, 10000000),
            'placed_at' => $this->faker->dateTimeBetween('-30 days'),
        ];
    }

    public function paid(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status' => 'paid',
                'status' => 'paid',
            ];
        });
    }

    public function delivered(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'payment_status' => 'paid',
                'status' => 'delivered',
            ];
        });
    }
}
