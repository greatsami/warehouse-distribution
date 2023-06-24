<?php

namespace Database\Factories;

use App\Enums\Role;
use App\Models\Client;
use App\Models\Company;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Factory;

final class MemberFactory extends Factory
{
    protected $model = Member::class;

    public function definition(): array
    {
        return [
            'role' => Role::USER,
            'client_id' => Client::factory(),
            'company_id' => Company::factory(),
        ];
    }

    public function role(Role $role): MemberFactory
    {
        return $this->state(
            state: static fn(array $attribute): array => [
                'role' => $role
            ],
        );
    }
}
