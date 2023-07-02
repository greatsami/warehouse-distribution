<?php
declare(strict_types=1);

namespace App\Http\Controllers\Orders;

use App\Commands\Orders\CreateNewOrder;
use App\Http\Requests\Orders\StoreRequest;
use App\Http\Resources\Orders\OrderResource;
use App\Queries\Orders\FetchClientByUlid;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Cache;
use Treblle\Tools\Http\Enums\Status;
use Treblle\Tools\Http\Responses\ModelResponse;

final readonly class StoreController
{
    public function __construct(
        private FetchClientByUlid $query,
        private CreateNewOrder    $command,
    )
    {}

    public function __invoke(StoreRequest $request, string $ulid):Responsable
    {
        // fetch client
        $client = $this->query->handle(
            ulid: $ulid
        );
        if (!$client) {
            throw new ModelNotFoundException(
                message: "Cannot find a client with ID: [$ulid].",
                code: Status::NOT_FOUND->value,
            );
        }

        // create a new order.
        $order = $this->command->handle(
            ulid: $ulid
        );

        // set as default order for client
        Cache::put(
            key: $client?->getKey() . '_active_order',
            value: $order->getKey()
        );

        // return order for client
        return new ModelResponse(
            data: new OrderResource(
                resource: $order,
            ),
            status: Status::CREATED
        );
    }
}
