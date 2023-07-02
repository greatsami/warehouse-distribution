<?php
declare(strict_types=1);

namespace App\Http\Controllers\Products;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use JustSteveKing\Launchpad\Http\Responses\ModelResponse;

final class ShowController
{

    public function __invoke(Request $request, string $ulid): Responsable
    {
        $product = Product::query()->findOrFail(
            id: $ulid
        );
        if (! $product) {
            throw new ModelNotFoundException(
                message: "Np product for ID [$ulid]"
            );
        }

        return new ModelResponse(
            data: new ProductResource(
                resource: $product,
            )
        );
    }
}
