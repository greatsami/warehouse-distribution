<?php
declare(strict_types=1);
namespace App\Http\Controllers\Products;

use App\Http\Responses\PaginatedResponse;
use App\Services\SearchService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

final readonly class IndexController
{

    public function __construct(
        private SearchService $search,
    )
    {
    }

    public function __invoke(Request $request): Responsable
    {

        $products = $this->search->search(
            term: $request->get('search'),
            limit: 15,
            offset: ($request->get('page', 1) - 1) * 15,
        );
        return new PaginatedResponse(
            data: new LengthAwarePaginator(
                items: $products['hits'],
                total: $products['nbHits'],
                perPage: 15,
                currentPage: $request->get('page', 1),
            ),
        );

        // return new CollectionResponse(
        //     data: ProductResource::collection(
        //         resource: Product::search(
        //             query: $request->get('search', ''),
        //         )->paginate(),
        //     )
        // );
    }
}
