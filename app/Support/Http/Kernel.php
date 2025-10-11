<?php

namespace App\Support\Http;

class Kernel
{
    private ?Request $request = null;
    private $router;

    protected array $middleware = [
        \App\Middleware\AuthMiddleware::class,
        \App\Middleware\VerifyCsrfToken::class,
    ];

    public function __construct(Request $request, $router)
    {
        $this->request = $request;
        $this->router = $router;
    }

    public function handle()
    {
        $destination = fn($req) => $this->router->dispatch($req);
        return $this->runPipeline($this->request, $this->middleware, $destination);
    }

    public function runPipeline($request, array $middleware, callable $destination)
    {
        $next = array_reduce(
            array_reverse($middleware),
            fn($next, $middlewareClass) => fn($req) => (new $middlewareClass())->handle($req, $next),
            $destination
        );

        return $next($request);
    }
}