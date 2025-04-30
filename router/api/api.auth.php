<?php

use App\Router\Router;

$router = new Router();


$router->post('/api/auth/login',         fn() => '../api/session/login.api.php',     'view');
$router->post('/api/auth/logout',        fn() => '../api/session/logout.api.php',    'view');


$router->post('/{any}', function () {
    return ["text" => "ERROR de la API", "status" => false, "code" => 404];
}, 'json');



$router->dispatch();
