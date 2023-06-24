<?php
declare(strict_types=1);
namespace App\Services;

use App\Enums\Role;

final class AuthorizationService
{
    public function listClients(Role $role): bool
    {
        return in_array(
            needle: $role,
            haystack: [Role::ADMIN, Role::MANAGER, Role::WAREHOUSE],
            strict: true
        );
    }
}
