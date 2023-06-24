<?php
declare(strict_types=1);
namespace App\Commands\Companies;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use JustSteveKing\Launchpad\Database\Portal;

final class FirstOrCreate
{

    public function __construct(
        private readonly Portal $database,
    )
    {
    }

    public function handle(string $name, string $email): Model|Company
    {
        return $this->database->transaction(
            callback: fn () => Company::query()->create(
                attributes: ['name' => $name,'email' => $email,],
            )
        );
    }
}
