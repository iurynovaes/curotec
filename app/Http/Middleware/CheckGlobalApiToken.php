<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGlobalApiToken
{
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('X-API-TOKEN') ?? $request->query('api_token');

        if (!$token || $token !== env('API_GLOBAL_TOKEN')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
