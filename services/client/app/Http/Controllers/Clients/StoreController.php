<?php
declare(strict_types=1);

namespace App\Http\Controllers\Clients;

use App\Commands\Clients\CreateNewClient;
use App\Commands\Companies\FirstOrCreate;
use App\Exceptions\WriteException;
use App\Http\Requests\Clients\StoreRequest;
use App\Http\Resources\ClientResource;
use Illuminate\Contracts\Support\Responsable;
use JustSteveKing\Launchpad\Http\Responses\ModelResponse;
use Throwable;
use Treblle\Tools\Http\Enums\Status;

readonly class StoreController
{
    /**
     * @param CreateNewClient $command
     * @param FirstOrCreate $createCompany
     */
    public function __construct(
        private CreateNewClient $command,
        private FirstOrCreate   $createCompany,
    )
    {
    }

    /**
     * @param StoreRequest $request
     * @return Responsable
     * @throws WriteException|Throwable
     */
    public function __invoke(StoreRequest $request): Responsable
    {
        $payload = $request->payload();
        try {
            $company = $this->createCompany->handle(
                name: $payload->company,
                email: $payload->email,
            );
        } catch (Throwable $exception) {
            throw new WriteException(
                message: $exception->getMessage(),
                code: (int)$exception->getCode(),
                previous: $exception,
            );
        }

        $payload = $payload->company(
            company: $company->getKey(),
        );

        try {
            $client = $this->command->handle(
                payload: $payload,
            );
        } catch (Throwable $exception) {
            throw new WriteException(
                message: $exception->getMessage(),
                code: $exception->getCode(),
                previous: $exception,
            );
        }

        return new ModelResponse(
            data: new ClientResource(
                resource: $client,
            ),
            status: Status::CREATED,
        );
    }
}
