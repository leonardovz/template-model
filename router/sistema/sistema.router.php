<?php

// Uso del Router

use App\Router\Router;

$router = new Router();

$router->get('/sistema/',           fn() => '../views/sistema/index/index.view.php', 'view');
$router->get('/sistema/usuarios',   fn() => '../views/sistema/usuarios/usuarios.view.php', 'view');

$router->dispatch();
