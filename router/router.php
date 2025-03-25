<?php

// Uso del Router

use App\Router\Router;

$router = new Router();

$router->get('/', fn() => '../views/home.php', 'view');
$router->get('/api/{any}', fn($any) => '../router/api/api.router.php', 'view');
$router->get('/vista/{id}', fn($id) => '../views/home.php', 'view');
$router->get('/redirigir', fn() => 'https://www.google.com', 'redirect');
$router->get('/sistema/{any}', fn($any) => '../router/sistema/sistema.router.php', 'view');

$router->dispatch();
