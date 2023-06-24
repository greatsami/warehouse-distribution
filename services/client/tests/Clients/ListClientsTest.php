<?php
declare(strict_types=1);

use App\Exceptions\AuthenticationException;
use App\Http\Controllers\Clients\IndexController;

it('will throw an exception if not authenticated', function (): void {
    $this->getJson(
        uri: action(IndexController::class),
    );
})->throws(AuthenticationException::class);
