<?php

namespace App\Support\Http;

class Route
{
    protected array $routes = [];

    protected function formatPath(mixed $action): array
    {
        if (is_array($action)) {
            return $action;
        } elseif (is_string($action)) {
            return explode('@', $action);
        }

        throw new \RuntimeException("Unsupported route action type.");
    }

    public function get(string $uri, mixed $action): void
    {
        $this->addRoute('GET', $uri, $action);
    }

    public function post(string $uri, mixed $action): void
    {
        $this->addRoute('POST', $uri, $action);
    }

    public function delete(string $uri, mixed $action): void
    {
        $this->addRoute('DELETE', $uri, $action);
    }

    protected function addRoute(string $method, string $uri, mixed $action): void
    {
        [$controller, $func] = $this->formatPath($action);
        $this->routes[$method][$uri] = [
            'controller' => "\\App\\Controllers\\{$controller}",
            'func' => "{$func}"
        ];
    }
}