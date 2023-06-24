<?php

declare(strict_types=1);
namespace App\Http\Controllers\Clients;

use App\Enums\Role;
use App\Exceptions\AuthenticationException;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Services\AuthorizationService;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use JustSteveKing\Launchpad\Http\Responses\CollectionResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Treblle\Tools\Http\Enums\Status;

final readonly class IndexController
{

    /**
     * @param AuthorizationService $service
     */
    public function __construct(
        private AuthorizationService $service,
    )
    {
    }

    /**
     * @param Request $request
     * @return Responsable
     * @throws AuthenticationException
     */
    public function __invoke(Request $request): Responsable
    {
        if(! $this->service->listClients(
            role: Role::tryFrom(data_get($request->all(), 'identity.role'))
        )) {
            throw new AuthenticationException(
                message: 'Invalid role to access this resource.',
                code: Status::FORBIDDEN->value,
            );
        }

        // list clients
        return new CollectionResponse(
            data: ClientResource::collection(
                resource: QueryBuilder::for(
                    subject: Client::query(),
                )->allowedIncludes([
                    'company'
                ])->latest()->paginate(),
            ),
        );


    }
}
