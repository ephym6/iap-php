<?php

require 'ClassAutoLoad.php';
class Router {
    private array $routes = [];

    public function add(string $path, callable $handler): void {
        $this->routes[$path] = $handler;
    }

    public function dispatch(string $uri): void {
        // Start with the request path
        $path = parse_url($uri, PHP_URL_PATH) ?? '/';

        // Normalize slashes
        $path = str_replace('\\', '/', $path);
        $scriptName = str_replace('\\', '/', $_SERVER['SCRIPT_NAME'] ?? '');
        $scriptDir  = rtrim(str_replace('\\', '/', dirname($scriptName)), '/');

        // Strip script name (/index.php) if present
        if ($scriptName && str_starts_with($path, $scriptName)) {
            $path = substr($path, strlen($scriptName));
        }
        // Otherwise strip the script directory (/myapp) if present
        elseif ($scriptDir && $scriptDir !== '/' && str_starts_with($path, $scriptDir . '/')) {
            $path = substr($path, strlen($scriptDir));
        }

        // Handle cases like /index.php/register (leftover index.php in path)
        $path = ltrim($path, '/');
        if (str_starts_with($path, 'index.php')) {
            $path = ltrim(substr($path, strlen('index.php')), '/');
        }

        // Final normalization
        $path = trim($path, '/');
        $path = $path !== '' ? $path : 'home';

        if (isset($this->routes[$path])) {
            call_user_func($this->routes[$path]);
        } else {
            http_response_code(404);
            echo "404 - Page not found";
            // For debugging, uncomment the next line to see what path was resolved:
            // error_log("Router unresolved path: " . $path);
        }
    }
}
