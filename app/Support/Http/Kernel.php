<?php

namespace App\Support\Http;

class Kernel
{
    private ?Request $request = null;
    private $router;

    public function __construct(Request $request, $router)
    {
        $this->request = $request;
        $this->router = $router;
    }

    public function handle()
    {
        $response = $this->router->dispatch($this->request);
        return $response;
    }
}