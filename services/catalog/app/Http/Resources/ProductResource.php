<?php
declare(strict_types=1);
namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Product $resource
 */
final class ProductResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->name,
            'status' => $this->resource->status,
            'description' => $this->resource->description,
            'price' => $this->resource->price,
            'cost' => $this->resource->cost,
            'weight' => $this->resource->weight,
            'dimensions' => $this->resource->dimensions,
            'stock' => $this->resource->stock,
            'category' => new CategoryResource(
                resource: $this->category,
            ),
            'supplier' => new SupplierResource(
                resource: $this->supplier,
            ),
            'warehouse' => new WarehouseResource(
                resource: $this->warehouse,
            ),
        ];
    }
}
