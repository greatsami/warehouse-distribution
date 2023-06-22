<?php

namespace App\Http\Middleware;

use App\Exceptions\AuthenticationException;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

final class ServiceAuthentication
{
    public function handle(Request $request, Closure $next): Response
    {
        // does the request have an auth header?
        if (!$request->hasHeader('Authorization')) {
            throw new AuthenticationException(
                message: 'Please include your access Token in the request.',
                guards: ['api']
            );
        }

        // is this token valid?
        $token = Str::of(
            string: $request->header('Authorization'),
        )->after(
            search: 'Bearer ',
        )->toString();

        if (! Cache::get($token)) {
            throw new AuthenticationException(
                message: 'Invalid Authentication.',
                guards: ['api']
            );
        }

        return $next($request);
    }
}
