<?php
declare(strict_types=1);
namespace App\Queries\Orders;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

final class FetchOrdersForClient
{
    public function handle(string $ulid, array $include = []): Collection
    {
        return Order::query()->with($include)->where('client_id', $ulid)->get();
    }
}
