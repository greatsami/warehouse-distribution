<?php
declare(strict_types=1);
namespace App\Http\Resources;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property-read Supplier $resource
 */
final class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->getKey(),
            'name' => $this->resource->name,
            'website' => $this->resource->website,
            'email' => $this->resource->email,
            'reference' => $this->resource->reference,
        ];
    }
}
