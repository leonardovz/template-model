<?php

namespace App\Router;

use App\Config\Config;

class Router
{
    private array $routes = [];
    private array $middlewares = [];
    private $wildcardRoutes = [];

    public function addRoute(string $method, string $path, callable $handler, string $type = 'json', array $middlewares = []): void
    {
        if (strpos($path, "{any}") !== false) {
            $this->wildcardRoutes[$method][] = [
                'pattern' => str_replace('{any}', '(.*)', $this->normalizePath($path)),
                'handler' => $handler,
                'type' => $type,
                'middlewares' => $middlewares
            ];
        } else {
            $this->routes[strtoupper($method)][$this->normalizePath($path)] = [
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

    public function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];

        // Obtener la URI sin la base del proyecto
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $scriptDir = Config::proyect();
        $uri = substr($uri, strlen($scriptDir));

        $uri = $this->normalizePath($uri);

        // Buscar coincidencias exactas
        foreach ($this->routes[$method] ?? [] as $route => $config) {
            if ($route === $uri) {
                $this->executeHandler($config);
                return;
            }
        }

        // Buscar coincidencias con {any}
        foreach ($this->wildcardRoutes[$method] ?? [] as $route) {
            if (preg_match("#^" . $route['pattern'] . "$#", $uri, $matches)) {
                $params = array_slice($matches, 1);
                $this->executeHandler($route, $params);
                return;
            }
        }

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
}
