<?php

namespace App\Database;

class Router
{
    protected string $uri;
    protected string $path;
    protected string $method;

    public function __construct(string $uri, mixed $action)
    {
        $this->uri = $uri;
        $this->formatPath($action);
    }

    protected function formatPath(mixed $action)
    {
        if (is_array($action)) {
            [$this->path, $this->method] = $action;
        } elseif (is_string($action)) {
            [$this->path, $this->method] = explode('@', $action);
        } else {
            throw new \Exception("The following action is unsupported: {$action}");
        }
    }
}