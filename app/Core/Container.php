<?php

namespace App\Core;

class Container {
    protected array $bindings = [];
    protected array $instances = [];

    public function bind(string $abstract, callable $factory): void
    {
        // Transient service
        $this->bindings[$abstract] = $factory;
    }

    public function singleton(string $abstract, callable $factory): void
    {
        // Singleton service
        $this->bindings[$abstract] = $factory;
        $this->instances[$abstract] = null;
    }

    public function get(string $abstract)
    {
        // If it's a singleton and already created, return existing
        if (array_key_exists($abstract, $this->instances) && $this->instances[$abstract] !== null) {
            return $this->instances[$abstract];
        }

        if (!isset($this->bindings[$abstract])) {
            throw new \Exception("Service [$abstract] not bound in container.");
        }

        $object = call_user_func($this->bindings[$abstract], $this);

        // Cache if singleton
        if (array_key_exists($abstract, $this->instances)) {
            $this->instances[$abstract] = $object;
        }

        return $object;
    }
}