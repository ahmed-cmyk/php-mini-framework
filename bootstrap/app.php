<?php

use App\Core\Container;
use App\Providers\AppServiceProvider;
use App\Support\Http\Request;

require __DIR__ . '/../vendor/autoload.php';

// 1. Create container
$app = new Container();

// 2. Register provider
$provider = new AppServiceProvider($app);
$provider->register();

return $app;