<?php

if (!function_exists('base_path')) {
    function base_path($path = '')
    {
        return rtrim(__DIR__ . '/../' . $path, '/');
    }
}

if (!function_exists('config')) {
    function config(string $key)
    {
        $path = __DIR__ . '/../config/' . $key . '.php';
        if (!file_exists($path)) {
            throw new Exception("Config file not found: $key");
        }

        return require $path;
    }
}

if (!function_exists('env')) {
    function env(string $key, mixed $default = null)
    {
        $value = getenv($key);
        return $value === false ? $default : $value;
    }
}

if (!function_exists('redirect')) {
    function redirect(string $url , int $status = 302)
    {
        return \App\Support\Http\Response::redirect($url, $status);
    }
}

if (!function_exists('response')) {
    function response()
    {
        return new \App\Support\Http\Response();
    }
}

if (!function_exists('view')) {
    function view(string $model)
    {
        $path = __DIR__ . "/../views/{$model}.view.php";
        if (!file_exists($path)) {
            throw new \Exception("View not found: {$path}");
        }

        return require $path;
    }
}