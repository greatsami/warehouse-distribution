<?php

declare(strict_types=1);

use App\Http\Controllers\Auth\RegisterController;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Treblle\Tools\Http\Enums\Status;

it('validates the users input', function (): void {
    $this->postJson(
        uri: action(RegisterController::class),
        data: []
    )->assertStatus(
        status: Status::UNPROCESSABLE_CONTENT->value,
    )->assertJsonValidationErrorFor(
        key: 'name',
    )->assertJsonValidationErrorFor(
        key: 'email',
    )->assertJsonValidationErrorFor(
        key: 'password',
    );
});


it('creates the new user record', function (): void {
    expect(
        User::query()->count(),
    )->toEqual(0);


    $this->postJson(
        uri: action(RegisterController::class),
        data: [
            'name' => 'Sami',
            'email' => 'sami@gmail.com',
            'password' => '123123123',
        ]
    )->assertStatus(
        status: Status::CREATED->value,
    );

    expect(
        User::query()->count(),
    )->toEqual(1);
});


it('will store an access token on Cache', function (): void {
    $response = $this->postJson(
        uri: action(RegisterController::class),
        data: [
            'name' => 'Sami',
            'email' => 'sami@gmail.com',
            'password' => '123123123',
        ]
    );

    // dd($response->json('message'));

    expect(
        Cache::get($response->json('message'))
    )->not->toBeNull()->toBeArray()->toHaveKeys(['id', 'role']);
});
