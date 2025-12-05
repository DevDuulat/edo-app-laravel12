<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySyncToken
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->path() === 'telegram/webhook') {
            return $next($request);
        }

        $token = $request->bearerToken();

        if ($token !== env('SECRET_TOKEN')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
