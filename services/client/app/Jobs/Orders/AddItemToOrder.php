<?php
declare(strict_types=1);

namespace App\Jobs\Orders;

use App\Enums\OrderStatus;
use App\Models\Client;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\CatalogService;
use Brick\Money\Money;
use http\Exception\InvalidArgumentException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use JustSteveKing\Launchpad\Database\Portal;
use function PHPUnit\Framework\callback;

final class AddItemToOrder implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        public readonly string $client,
        public readonly string $order,
        public readonly string $product,
        public readonly int $quantity,
        public readonly int $discount,
    ){}

    public function handle(CatalogService $service, Portal $database): void
    {
        // check that client and order exist..
        if (! Client::query()->where('id', $this->client)->exists()) {
            throw new InvalidArgumentException(
                message: "Client does not exist: [$this->client]"
            );
        }

        /*if (! Order::query()->where('id', $this->order)->exists()) {
            throw new InvalidArgumentException(
                message: "Order does not exist: [$this->order]"
            );
        }*/

        $order = Order::query()->find(
            id: $this->order
        );

        if (! $order) {
            Order::query()->create(
                attributes: [
                    'status' => OrderStatus::DRAFT,
                    'client_id' => $this->client,
                ]
            );
        }

        $item = $service->lookup($this->product);
        if (! $item) {
            throw new InvalidArgumentException(
                message: "Invalid Product ID passed: [$this->product]",
            );
        }


        $exists = OrderItem::query()->where('product', $this->product)->where('order_id', $this->order)->first();

        if ($exists) {
            $exists->update([
                'quantity' => $this->quantity + $exists->quantity,
                'price' => $exists->price + Money::of(
                    amount: $item['price']['amount'],
                    currency: $item['price']['currency'],
                )->getAmount()->toInt(),
            ]);
        } else {

            $database->transaction(
                callback: fn() => OrderItem::query()->create(
                    attributes: [
                        'product' => $this->product,
                        'order_id' => $this->order,
                        'quantity' => $this->quantity,
                        'price' => Money::of(
                            amount: $item['price']['amount'],
                            currency: $item['price']['currency'],
                        )->getAmount()->toInt(),
                        'discount' => $this->discount,
                    ]
                ),
            );
        }

        $database->transaction(
            callback: fn() => $order->increment(
                'weight',
                $item['weight'] * $this->quantity,
            ),
        );


    }
}
