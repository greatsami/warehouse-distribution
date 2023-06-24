<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class ServiceAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {
        // does the request have an auth header?
        if (! $request->hasHeader('authorization')) {
            throw new AuthenticationException(
                message: 'Please include your access Token in the request.',
            );
        }

        // is this token valid?
        $token = Str::of(
            string: $request->header('Authorization'),
        )->after(
            search: 'Bearer ',
        )->toString();

        if (! $identity = Redis::get($token)) {
            throw new AuthenticationException(
                message: 'Invalid Authentication.',
            );
        }

        $request->merge([
            'identity' => \json_decode(
                json: $identity,
                associative: true,
                flags: JSON_THROW_ON_ERROR
            )
        ]);

        return $next($request);
    }
}
