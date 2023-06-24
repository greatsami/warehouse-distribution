<?php
declare(strict_types=1);
namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

final class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'website' => fake()->url(),
            'email' => fake()->unique()->companyEmail(),
            'reference' => fake()->imei(),
        ];
    }
}
