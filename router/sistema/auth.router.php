<?php

// Uso del Router

use App\Models\SessionModel;
use App\Router\Router;

$router = new Router();
$SSM    = new SessionModel();
if ($SSM->verificarToken()) Router::location("sistema/");


$router->get('/auth/login',     fn() => '../views/login/login.view.php', 'view');


$router->dispatch();
