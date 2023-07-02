<?php
declare(strict_types=1);

namespace App\Http\Responses;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\AbstractPaginator;
use Treblle\Tools\Http\Enums\Status;

final readonly class PaginatedResponse implements Responsable
{

    public function __construct(
        private AbstractPaginator $data,
        private Status            $status = Status::OK,
    )
    {
    }

    public function toResponse($request): JsonResponse
    {
        return new JsonResponse(
            data: $this->data,
            status: $this->status->value,
        );
    }
}
