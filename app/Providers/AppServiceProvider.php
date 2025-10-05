<?php

namespace App\Providers;

use App\Core\Container;

class AppServiceProvider
{
    private ?Container $app = null;

    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public static function boot(): void
    {
    }

    public function register(): void
    {
        $this->app->singleton('db', fn() => new \App\Database\Connection(config('db')));
        $this->app->singleton('db.builder', fn($app) => new \App\Database\DB($app));
        $this->app->singleton('request', fn() => new \App\Support\Http\Request());
        $this->app->singleton('kernel', function ($app) {
            $request = $app->get('request');
            return new \App\Support\Http\Kernel($request);
        });
    }
}