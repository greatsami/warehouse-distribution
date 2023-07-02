<?php
declare(strict_types=1);

namespace App\Commands\Orders;

use App\Enums\OrderStatus;
use App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use JustSteveKing\Launchpad\Database\Portal;

class CreateNewOrder
{

    public function __construct(
        private readonly Portal $database,
    )
    {}

    public function handle(string $ulid): Model|Order
    {
        return $this->database->transaction(
            callback: fn () => Order::query()->create(
                attributes: [
                    'status' => OrderStatus::DRAFT,
                    'client_id' => $ulid
                ]
            )
        );
    }
}
