<?php
declare(strict_types=1);
namespace App\Http\Controllers\Orders;

use App\Http\Resources\Orders\OrderResource;
use App\Queries\Orders\FetchClientByUlid;
use App\Queries\Orders\FetchOrdersForClient;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use JustSteveKing\Launchpad\Http\Responses\CollectionResponse;
use Treblle\Tools\Http\Enums\Status;

final class IndexController
{

    public function __construct(
        private readonly FetchClientByUlid $query,
        private readonly FetchOrdersForClient $ordersQuery,
    )
    {}

    public function __invoke(Request $request, string $ulid): Responsable
    {
        // does this client exist?
        $client = $this->query->handle(
            ulid: $ulid
        );

        if (!$client) {
            throw new ModelNotFoundException(
                message: "Cannot find a client with ID: [$ulid].",
                code: Status::NOT_FOUND->value,
            );
        }

        // get all orders for this client.

        return new CollectionResponse(
            data: OrderResource::collection(
                resource: $this->ordersQuery->handle(
                    ulid: $client->getKey(),
                    include: [
                        'client',
                        'items',
                    ]
                ),
            ),
        );
        // return the response.
    }
}
