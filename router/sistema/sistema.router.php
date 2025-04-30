<?php

// Uso del Router

use App\Models\SessionModel;
use App\Router\Router;

$SSM    = new SessionModel();
$router = new Router();

if (!$SSM->verificarToken()) Router::location("auth/login");

$router->get('/sistema/',           fn() => '../views/sistema/index/index.view.php', 'view');
$router->get('/sistema/usuarios',   fn() => '../views/sistema/usuarios/usuarios.view.php', 'view');

$router->dispatch();
