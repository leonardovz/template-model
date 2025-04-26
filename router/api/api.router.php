<?php

use App\Router\Router;

$router = new Router();


$router->post('/api/auth/logout',        fn() => '../api/session/logout.api.php',    'view');

$router->post('/api/usuarios/create',    fn() => '../api/usuarios/create.api.php',   'view');
$router->post('/api/usuarios/update',    fn() => '../api/usuarios/update.api.php',   'view');
$router->post('/api/usuarios/show',      fn() => '../api/usuarios/show.api.php',     'view');



$router->get('/api/{any}', function () {
    return ["message" => "ERROR de la API"];
}, 'json');



$router->dispatch();
