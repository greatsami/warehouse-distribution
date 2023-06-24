<?php
declare(strict_types=1);
namespace App\Http\Resources;

use App\Http\Resources\Clients\CompanyResource;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JustSteveKing\Launchpad\Http\Resources\DateResource;

/**
 * @property-read Client $resource
 */
final class ClientResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'name' => $this->resource->name,
            'email' => $this->resource->email,
            'created' => new DateResource(
                resource: $this->resource->created_at,
            ),
            'company' => new CompanyResource(
                resource: $this->whenLoaded(
                    relationship: 'company',
                ),
            ),
        ];
    }
}
