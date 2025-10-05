<?php

use App\Support\Http\Request;

require_once __DIR__ . '/../bootstrap/helpers.php';

$app = require __DIR__ . '/../bootstrap/app.php';

// Register the Request binding (transient)
$app->bind('request', fn() => new Request());

// Resolve Kernel and Request
$kernel = $app->get('kernel');
$request = $app->get('request');

// Handle the request and send the response
$response = $kernel->handle($request);
$response->send();