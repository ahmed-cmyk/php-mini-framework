<?php

use App\Core\Container;
use App\Providers\AppServiceProvider;

require __DIR__ . '/../vendor/autoload.php';

// 1. Create container

$app = new Container();

// 2. Set Facade application container
\App\Support\Facade::setFacadeApplication($app);

// 3. Register provider

$provider = new AppServiceProvider($app);
$provider->register();

// Boot RouteServiceProvider to load routes
if (method_exists($provider, 'registerRouteServiceProvider')) {
	$provider->registerRouteServiceProvider();
}

return $app;