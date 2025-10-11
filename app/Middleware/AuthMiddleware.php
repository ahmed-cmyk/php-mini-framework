<?php

namespace App\Middleware;

use App\Support\Http\Request;

class AuthMiddleware
{
    public function handle(Request $request, callable $next)
    {
        // Example authentication check
        // if (!$request->user()) {
        //     throw new \Exception('Unauthorized');
        // }
        printf("Authenticated\n");
        return $next($request);
    }
}