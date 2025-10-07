<?php

namespace App\Providers;

class RouteServiceProvider
{
    public function register(): void
    {
        // Load routes from routes/web.php file
        $this->loadRoutesFrom(base_path('routes/web.php'));
    }

    protected function loadRoutesFrom(string $path): void
    {
        if (!file_exists($path)) {
            throw new \RuntimeException("There is no routes file with the path {$path}");
        }

        require $path;
    }
}