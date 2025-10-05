<?php

namespace App\Providers;

use App\Core\Container;

class RouteServiceProvider
{
    private ?Container $app = null;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function register(): void
    {
        //
    }
}