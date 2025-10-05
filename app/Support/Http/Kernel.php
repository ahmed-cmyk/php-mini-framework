<?php

namespace App\Support\Http;

class Kernel
{
    private ?Request $request = null;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function handle()
    {
        $router = new Route();
        $response = $router->dispatch($this->request);
        return $response;
    }
}