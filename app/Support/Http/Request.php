<?php

namespace App\Support\Http;

use App\Contracts\Support\DataBag;

class Request implements DataBag
{
    protected array $data = [];

    public function all(): array
    {
        return $this->data;
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->data[$key] ?? $default;
    }

    public function set(string $key, mixed $value): void
    {
        $this->data[$key] = $value;
    }

    public function header(string $key, mixed $default = null): mixed
    {
        return $_SERVER[$key] ?? $default;
    }

    public function method(): string
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public function path(): string
    {
        return $_SERVER['PATH_INFO'];
    }

    public function uri(): string
    {
        return $_SERVER['REQUEST_URI'];
    }

    public function url(): string
    {
        $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
        $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
        $uri = $_SERVER['REQUEST_URI'] ?? '/';

        return "{$scheme}://{$host}{$uri}";
    }

    // Array access methods
    public function offsetExists($key): bool
    {
        return isset($this->data[$key]);
    }

    public function offsetGet($key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function offsetSet($key, $value): void
    {
        $this->data[$key] = $value;
    }

    public function offsetUnset($key): void
    {
        unset($this->data[$key]);
    }
}