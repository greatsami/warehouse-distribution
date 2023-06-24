<?php
declare(strict_types=1);
namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

final class DatabaseSeeder extends Seeder
{

    public function run(): void
    {
        $this->command->withProgressBar(
            totalSteps: 10,
            callback: fn () => Product::factory()->count(10)->create(),
        );
    }
}
