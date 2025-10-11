<?php

use App\Core\Container;
use App\Providers\AppServiceProvider;
use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';

// 1. Create container

$app = new Container();

// 2. Set Facade application container
\App\Support\Facade::setFacadeApplication($app);

// 3. Setup environment variables
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// 4. Register provider
$provider = new AppServiceProvider($app);
$provider->register();

// Boot RouteServiceProvider to load routes
if (method_exists($provider, 'registerRouteServiceProvider')) {
	$provider->registerRouteServiceProvider();
}

return $app;