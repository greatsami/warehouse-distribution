<?php
declare(strict_types=1);
namespace Database\Factories;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderItemFactory extends Factory
{

    protected $model = OrderItem::class;

    public function definition(): array
    {
        return [
            'product' => fake()->uuid(),
            'quantity' => fake()->numberBetween(
                int1: 1,
                int2: 10
            ),
            'price' => fake()->numberBetween(
                int1: 100,
                int2: 10_000
            ),
            'discount' => fake()->numberBetween(
                int1: 1,
                int2: 100
            ),
            'order_id' => Order::factory(),
        ];
    }
}
