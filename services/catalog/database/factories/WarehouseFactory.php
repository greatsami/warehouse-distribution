<?php
declare(strict_types=1);
namespace Database\Factories;

use App\Enums\WarehouseStatus;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

final class WarehouseFactory extends Factory
{

    protected $model = Warehouse::class;

    public function definition(): array
    {
        return [
            'name' => fake()->city() . ' something',
            'manager' => fake()->name(),
            'email' => fake()->unique()->companyEmail(),
            'status' => WarehouseStatus::ONLINE,
            'address' => explode(',', fake()->address()),
        ];
    }
}
