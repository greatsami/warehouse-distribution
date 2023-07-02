<?php
declare(strict_types=1);

namespace App\Http\Controllers\Orders\Items;

use App\Http\Requests\Orders\Items\StoreRequest;
use App\Jobs\Orders\AddItemToOrder;
use Illuminate\Contracts\Support\Responsable;
use JustSteveKing\Launchpad\Http\Responses\MessageResponse;
use JustSteveKing\Launchpad\Queue\DispatchableCommandBus;
use Treblle\Tools\Http\Enums\Status;

final readonly class StoreController
{

    public function __construct(
        private DispatchableCommandBus $bus,
    )
    {}

    public function __invoke(StoreRequest $request, string $ulid, string $order): Responsable
    {
        $this->bus->dispatch(
            new AddItemToOrder(
                client: $ulid,
                order: $order,
                product: $request->string('product')->toString(),
                quantity: $request->integer('quantity'),
                discount: $request->integer('discount', 0),
            )
        );

        return new MessageResponse(
            data: [
                'message' => 'We are processing your request',
            ],
            status: Status::ACCEPTED,
        );
    }
}
