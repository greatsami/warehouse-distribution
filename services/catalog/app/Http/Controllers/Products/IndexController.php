<?php
declare(strict_types=1);
namespace App\Http\Controllers\Products;

use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use JustSteveKing\Launchpad\Http\Responses\CollectionResponse;

final class IndexController
{

    public function __invoke(Request $request): Responsable
    {
        return new CollectionResponse(
            data: ProductResource::collection(
                resource: Product::search(
                    query: $request->get('search', ''),
                )->paginate(),
            )
        );
    }
}
