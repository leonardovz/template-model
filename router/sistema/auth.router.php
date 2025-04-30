<?php

// Uso del Router

use App\Router\Router;

$router = new Router();

$router->get('/auth/login',     fn() => '../views/login/login.view.php', 'view');


$router->dispatch();
