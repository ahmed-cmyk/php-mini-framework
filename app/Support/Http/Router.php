<?php

namespace App\Support\Http;

class Router extends Route
{
    public function dispatch(Request $request): mixed
    {
        $method = $request->method();
        $uri = $request->uri();

        if (!isset($this->routes[$method][$uri])) {
            http_response_code(404);
            return "404 not found: {$uri}";
        }

        $route = $this->routes[$method][$uri];
        $controller = $route['controller'];
        $func = $route['func'];

        if (!class_exists($controller)) {
            throw new \RuntimeException("Controller {$controller} not found");
        }

        $instance = new $controller;
        
        if (!method_exists($instance, $func)) {
            throw new \RuntimeException("Method {$func} not found in {$controller}");
        }

        return call_user_func([$instance, $func], $request);
    }
}