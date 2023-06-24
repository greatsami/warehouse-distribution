<?php
declare(strict_types=1);
namespace Database\Factories;

use App\Enums\ProductStatus;
use App\Models\Category;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Warehouse;
use Illuminate\Database\Eloquent\Factories\Factory;

final class ProductFactory extends Factory
{

    protected $model = Product::class;

    public function definition(): array
    {
        return [
            'name' => fake()->word(),
            'status' => ProductStatus::IN_STOKE,
            'description' => fake()->paragraph(),
            'price' => $price = fake()->numberBetween(int1: 1_000, int2: 10_000),
            'cost' => $cost = round(num: ($price / 100) * 65),
            'weight' => fake()->numberBetween(int1: 1_000, int2: 5_000),
            'dimensions' => [
                'height' => $size = fake()->numberBetween(int1: 100, int2: 1_000) * $cost,
                'width' => $size,
                'depth' => $size,
            ],
            'stock' => fake()->numberBetween(int1: 0, int2: 100),
            'category_id' => Category::factory(),
            'supplier_id' => Supplier::factory(),
            'warehouse_id' => Warehouse::factory(),
        ];
    }
}
