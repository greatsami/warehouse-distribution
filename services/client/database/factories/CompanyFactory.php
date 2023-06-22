<?php
declare(strict_types=1);
namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

final class CompanyFactory extends Factory
{

    protected $model = Company::class;

    public function definition(): array
    {
        return [
            'name' => fake()->company(),
            'website' => fake()->url(),
            'email' => fake()->unique()->companyEmail(),
        ];
    }
}
