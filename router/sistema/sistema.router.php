<?php

// Uso del Router

use App\Router\Router;

$router = new Router();

$router->get('/sistema/usuarios', fn() => '../views/sistema/usuarios/usuarios.view.php', 'view');

$router->dispatch();
