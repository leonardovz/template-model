<?php

namespace App\Router;

use App\Config\Config;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private array $wildcardRoutes = [];
    private array $anyRoutes = [];
    private array $routeVars = [];

    public function addRoute(string $method, string $path, callable $handler, string $type = 'json', array $middlewares = []): void
    {
        $method = strtoupper($method);
        $normalizedPath = $this->normalizePath($path);

        // Check if the route contains the {any} pattern
        if (strpos($path, '{any}') !== false) {
            $basePath = str_replace('/{any}', '', $normalizedPath);
            $this->anyRoutes[$method][$basePath] = [
                'handler' => $handler,
                'type' => $type,
                'middlewares' => $middlewares
            ];
        }
        // Check if the route contains dynamic parameters
        elseif (strpos($path, '{') !== false) {
            $pattern = preg_replace('/\{(\w+)\}/', '(?P<$1>[^/]+)', $normalizedPath);
            $this->wildcardRoutes[$method][] = [
                'pattern' => "#^{$pattern}$#",
                'handler' => $handler,
                'type' => $type,
                'middlewares' => $middlewares,
                'originalPath' => $normalizedPath
            ];
        }
        // Standard route
        else {
            $this->routes[$method][$normalizedPath] = [
                'handler' => $handler,
                'type' => $type,
                'middlewares' => $middlewares
            ];
        }
    }

    public function get(string $path, callable $handler, string $type = 'json', array $middlewares = []): void
    {
        $this->addRoute('GET', $path, $handler, $type, $middlewares);
    }

    public function post(string $path, callable $handler, string $type = 'json', array $middlewares = []): void
    {
        $this->addRoute('POST', $path, $handler, $type, $middlewares);
    }

    public function put(string $path, callable $handler, string $type = 'json', array $middlewares = []): void
    {
        $this->addRoute('PUT', $path, $handler, $type, $middlewares);
    }

    public function delete(string $path, callable $handler, string $type = 'json', array $middlewares = []): void
    {
        $this->addRoute('DELETE', $path, $handler, $type, $middlewares);
    }

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Obtener la URI sin la base del proyecto
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $scriptDir = Config::proyect();
        $uri = substr($uri, strlen($scriptDir));
        $uri = $this->normalizePath($uri);

        // Split URI into segments for processing
        $uriSegments = explode('/', trim($uri, '/'));

        // 1. Buscar coincidencias exactas
        if (isset($this->routes[$method][$uri])) {
            $this->executeHandler($this->routes[$method][$uri]);
            return;
        }

        // 2. Buscar coincidencias con patrones dinámicos
        foreach ($this->wildcardRoutes[$method] ?? [] as $route) {
            if (preg_match($route['pattern'], $uri, $matches)) {
                // Extract named parameters
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                $this->routeVars = $params;
                $this->executeHandler($route, $params);
                return;
            }
        }

        // 3. Buscar coincidencias con rutas {any}
        foreach ($this->anyRoutes[$method] ?? [] as $basePath => $config) {
            if ($basePath === '/' || strpos($uri, $basePath) === 0) {
                // Extract the remaining path after the base path
                $remainingPath = substr($uri, strlen($basePath));
                if (empty($remainingPath) || $remainingPath[0] === '/') {
                    // Add the remaining path as a parameter
                    $params = ['any' => trim($remainingPath, '/')];
                    $this->routeVars = $params;
                    $this->executeHandler($config, $params);
                    return;
                }
            }
        }

        // No route found
        http_response_code(404);
        echo json_encode(["error" => "Ruta no encontrada"]);
    }

    private function executeHandler(array $config, array $params = []): void
    {
        // Ejecutar middlewares
        foreach ($config['middlewares'] as $middleware) {
            if (!$middleware($params)) {
                http_response_code(403);
                echo json_encode(["error" => "Acceso denegado"]);
                return;
            }
        }

        $response = call_user_func($config['handler'], ...$params);

        if ($config['type'] === 'view') {
            extract($params);
            require $response;
        } elseif ($config['type'] === 'redirect') {
            header("Location: $response");
            exit;
        } else {
            header('Content-Type: application/json');
            echo json_encode($response);
        }
    }

    private function normalizePath(string $path): string
    {
        return rtrim($path, '/') ?: '/';
    }

    /**
     * Get the extracted variables from the current route
     * 
     * @return array The route variables
     */
    public function getRouteVars(): array
    {
        return $this->routeVars;
    }

    /**
     * Clean and split a URI into segments
     * 
     * @param string $uri The URI to clean
     * @return array The URI segments
     */
    private function cleanUri(string $uri): array
    {
        $uri = trim($uri, '/');
        return !empty($uri) ? explode('/', $uri) : [];
    }
    public static function location($uri)
    {
        header("Location: " . Config::RUTA() . "$uri");
    }
}
