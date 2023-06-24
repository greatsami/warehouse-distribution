<?php
declare(strict_types=1);
namespace App\Http\Resources\Clients;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JustSteveKing\Launchpad\Http\Resources\DateResource;

/**
 * @property-read Company $resource
 */
final class CompanyResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'website' => $this->resource->website,
            'created' => new DateResource(
                resource: $this->resource->created_at,
            ),
        ];
    }
}
