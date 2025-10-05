<?php

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