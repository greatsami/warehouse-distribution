<?php
declare(strict_types=1);
namespace App\Queries\Orders;

use Illuminate\Database\Eloquent\Collection;

final class FetchOrdersForClient
{
    public function handle(string $ulid): Collection
    {
        // return Order
    }
}
