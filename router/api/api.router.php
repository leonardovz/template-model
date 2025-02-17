<?php

use App\Router\Router;

$router = new Router();


$router->get('/api/update', function () {
    return ["message" => "Actualización de la API"];
}, 'json');

$router->get('/api/ayuda', function () {
    return ["message" => "Actualización de la API"];
}, 'json');


$router->get('/api/{any}', function () {
    return ["message" => "ERROR de la API"];
}, 'json');



$router->dispatch();
