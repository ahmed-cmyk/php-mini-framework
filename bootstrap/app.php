<?php

use App\Core\Container;
use App\Providers\AppServiceProvider;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// 1. Create container

$app = new Container();

// 2. Set Facade application container
\App\Support\Facade::setFacadeApplication($app);

// 3. Create .env file based on .env.example if it doesn't exist
if (!file_exists(__DIR__. '/../.env' && file_exists(__DIR__ . '/../.env.example'))) {
    copy(__DIR__ . '/../.env.example', __DIR__ . '/../.env');
}

// 4. Setup environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// 5. Register provider
$provider = new AppServiceProvider($app);
$provider->register();

// 6. Boot RouteServiceProvider to load routes
if (method_exists($provider, 'registerRouteServiceProvider')) {
	$provider->registerRouteServiceProvider();
}

return $app;