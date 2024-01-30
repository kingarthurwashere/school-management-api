<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    public function handle($request, Closure $next)
    {
        try {
            $token = JWTAuth::getToken();
            \Illuminate\Support\Facades\Log::info('Received token', ['token' => $token]);

            $user = JWTAuth::parseToken()->authenticate();
            \Illuminate\Support\Facades\Log::info('Authentication successful', ['user' => $user]);
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Authentication error', ['exception' => $e->getMessage()]);

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        \Illuminate\Support\Facades\Log::info('Middleware passed successfully');

        return $next($request);
    }
}
