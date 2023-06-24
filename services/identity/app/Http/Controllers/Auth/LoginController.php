<?php

declare(strict_types=1);
namespace App\Http\Controllers\Auth;

use App\Exceptions\AuthenticationException;
use App\Http\Requests\Auth\LoginRequest;
use App\Services\AuthenticationService;
use Illuminate\Contracts\Auth\Factory;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Support\Facades\Cache;
use Treblle\Tools\Http\Enums\Status;
use Treblle\Tools\Http\Responses\MessageResponse;

final readonly class LoginController
{

    public function __construct(
        private Factory $auth,
        private AuthenticationService $service
    )
    {}

    /**
     * @param LoginRequest $request
     * @return Responsable
     * @throws AuthenticationException
     */
    public function __invoke(LoginRequest $request): Responsable
    {
        // validate
        if (!$this->auth->guard()->attempt($request->only('email', 'password'))) {
            throw new AuthenticationException(
                message: 'Invalid credentials',
                code: Status::UNPROCESSABLE_CONTENT->value
            );
        }

        // create api access token based on authenticated user.
        $token = $this->service->createAccessToken(
            $this->auth->guard()->user()
        );


        // dd($token, Cache::get("$token"));

        // fetch the user record
        return new MessageResponse(
            data: [
                'message' => $token,
            ],
        );
        // store the api token on redis
        // return a response.

    }
}
