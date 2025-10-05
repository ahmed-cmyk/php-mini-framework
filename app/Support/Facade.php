<?php

namespace App\Support;

use App\Core\Container;

abstract class Facade
{
    protected static ?Container $app = null;

    public static function setFacadeApplication(Container $app): void
    {
        static::$app = $app;
    }

    protected static function getFacadeAccessor(): string
    {
        throw new \RuntimeException('Facade does not implement getFacadeAccessor()');
    }

    protected static function resolveInstance(string $name)
    {
        return static::$app->get($name);
    }

    public static function __callStatic($method, $args)
    {
        $instance = static::resolveInstance(static::getFacadeAccessor());

        if (!$instance) {
            throw new \RuntimeException('Face root not found: ' . static::getFacadeAccessor());
        }

        return $instance->$method(...$args);
    }
}