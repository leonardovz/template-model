<?php

// Uso del Router

use App\Router\Router;

$router = new Router();

$router->get('/', fn() => '../views/index/home.php', 'view');

$router->get('/app/{any}',  fn($any) => '../router/api/app.router.php', 'view');
$router->post('/app/{any}', fn($any) => '../router/api/app.router.php', 'view');

$router->get('/api/{any}',  fn($any) => '../router/api/api.router.php', 'view');
$router->post('/api/{any}', fn($any) => '../router/api/api.router.php', 'view');


$router->get('/vista/{id}', fn($id) => '../views/home.php', 'view');
$router->get('/vista/{id}/{nombre}', fn($id, $nombre) => '../views/home.php', 'view');
$router->get('/redirigir', fn() => 'https://www.google.com', 'redirect');
$router->get('/sistema/{any}', fn($any = null) => '../router/sistema/sistema.router.php', 'view');

$router->dispatch();
