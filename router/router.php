<?php

// Uso del Router

use App\Router\Router;
use App\Session\SessionManager;

new SessionManager();

$router = new Router();

$router->get('/', fn() => '../views/index/home.php', 'view');

$router->get('/app/{any}',  fn($any) => '../router/api/app.router.php', 'view');
$router->post('/app/{any}', fn($any) => '../router/api/app.router.php', 'view');

$router->get('/api/auth/{any}',  fn($any) => '../router/api/api.auth.php', 'view');
$router->post('/api/auth/{any}', fn($any) => '../router/api/api.auth.php', 'view');

$router->get('/api/{any}',  fn($any) => '../router/api/api.router.php', 'view');
$router->post('/api/{any}', fn($any) => '../router/api/api.router.php', 'view');



$router->get('/auth/{any}', fn($any = null) => '../router/sistema/auth.router.php', 'view');
$router->get('/sistema/{any}', fn($any = null) => '../router/sistema/sistema.router.php', 'view');

$router->dispatch();
