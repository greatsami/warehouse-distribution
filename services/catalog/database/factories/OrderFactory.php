<?php
declare(strict_types=1);
namespace Database\Factories;

use App\Enums\OrderStatus;
use App\Models\Client;
use App\Models\Order;
use Illuminate\Database\Eloquent\Factories\Factory;

final class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        return [
            'status' => OrderStatus::DRAFT,
            'weight' => fake()->numberBetween(int1: 100, int2: 10_000),
            'shipping' => [
                'company' => fake()->company(),
                'address' => fake()->address(),
            ],
            'billing' => [
                'company' => fake()->company(),
                'address' => fake()->address(),
            ],
            'client_id' => Client::factory(),
        ];
    }
}
