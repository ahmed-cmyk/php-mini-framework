<?php

namespace App\Middleware;

use App\Support\Http\Request;

class VerifyCsrfToken
{
    public function handle(Request $request, callable $next)
    {
        // Example CSRF token verification
        // $token = $request->header('X-CSRF-TOKEN');
        // if ($token !== session('csrf_token')) {
        //     throw new \Exception('CSRF token mismatch');
        // }
        return $next($request);
    }
}