<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\LoginController;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Treblle\Tools\Http\Enums\Status;


it('validates the users input', function (): void {
    $this->postJson(
        uri: action(LoginController::class),
        data: []
    )->assertStatus(
        status: Status::UNPROCESSABLE_CONTENT->value,
    )->assertJsonValidationErrorFor(
        key: 'email',
    )->assertJsonValidationErrorFor(
        key: 'password',
    );
});


it('returns the correct status if credentials are incorrect', function (): void {
    $user = User::factory()->create();
    $this->postJson(
        uri: action(LoginController::class),
        data: [
            'email' => $user->getAttribute('email'),
            'password' => 'password',
        ]
    )->assertStatus(
        status: Status::OK->value,
    );
});


it('will store an access token on Cache', function (): void {
    $user = User::factory()->create();
    $response = $this->postJson(
        uri: action(LoginController::class),
        data: [
            'email' => $user->getAttribute('email'),
            'password' => 'password',
        ]
    );

    // dd($response->json('message'));

    expect(
        Cache::get($response->json('message'))
    )->not->toBeNull()->toBeArray()->toHaveKeys(['id', 'role']);
});
