<?php
declare(strict_types=1);
namespace Database\Factories;

use App\Enums\CategoryStatus;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

final class CategoryFactory extends Factory
{

    protected $model = Category::class;

    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'status' => CategoryStatus::ACTIVE,
            'description' => fake()->paragraph(),
        ];
    }
}
