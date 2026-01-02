<?php

declare(strict_types=1);

namespace Core;

/**
 * Simple Router
 * 
 * Handles URL routing to controllers.
 * 
 * @package Core
 * @author Anderson
 * @version 2.0.0
 */
class Router
{
    /**
     * @var array Registered routes
     */
    private array $routes = [];

    /**
     * @var string Base path
     */
    private string $basePath;

    /**
     * Router constructor
     * 
     * @param string $basePath Base path for routes
     */
    public function __construct(string $basePath = '')
    {
        $this->basePath = $basePath;
    }

    /**
     * Register a GET route
     * 
     * @param string $path URL path
     * @param callable|array $handler Handler function or [Controller, method]
     * @return self
     */
    public function get(string $path, callable|array $handler): self
    {
        $this->routes['GET'][$path] = $handler;
        return $this;
    }

    /**
     * Register a POST route
     * 
     * @param string $path URL path
     * @param callable|array $handler Handler function or [Controller, method]
     * @return self
     */
    public function post(string $path, callable|array $handler): self
    {
        $this->routes['POST'][$path] = $handler;
        return $this;
    }

    /**
     * Dispatch the request to appropriate handler
     * 
     * @return void
     */
    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        // Remove base path from URI
        if (!empty($this->basePath)) {
            $uri = '/' . ltrim(str_replace($this->basePath, '', $uri), '/');
        }

        // Clean URI
        $uri = '/' . trim($uri, '/');

        // Find matching route
        if (isset($this->routes[$method][$uri])) {
            $handler = $this->routes[$method][$uri];
            $this->callHandler($handler);
            return;
        }

        // Check for dynamic routes with parameters
        foreach ($this->routes[$method] ?? [] as $route => $handler) {
            $pattern = preg_replace('/\{([a-zA-Z]+)\}/', '([^/]+)', $route);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $uri, $matches)) {
                array_shift($matches); // Remove full match
                $this->callHandler($handler, $matches);
                return;
            }
        }

        // 404 Not Found
        http_response_code(404);
        echo json_encode(['error' => 'Route not found']);
    }

    /**
     * Call the route handler
     * 
     * @param callable|array $handler Handler
     * @param array $params Parameters
     * @return void
     */
    private function callHandler(callable|array $handler, array $params = []): void
    {
        if (is_array($handler)) {
            [$controllerClass, $method] = $handler;
            $controller = new $controllerClass();
            call_user_func_array([$controller, $method], $params);
        } else {
            call_user_func_array($handler, $params);
        }
    }
}
