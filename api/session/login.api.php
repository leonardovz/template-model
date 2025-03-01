<?php

use App\Models\Usuarios;
use App\Router\HttpData;

$correo = HttpData::post("correo");
$password = HttpData::post("password");



$user = Usuarios::getUser("correo", $correo);

if (!$user) {
    die(json_encode([
        "status" => false,
        "response" => "warning",
        "message" => "Usuario no encontrado"
    ]));
}

if (!password_verify($password, $user["password"])) {
    die(json_encode([
        "status" => false,
        "response" => "warning",
        "message" => "Contraseña incorrecta"
    ]));
}

$session_user = [
    "id"        => $user["id_usuario"],
    "nombre"    => $user["nombre"],
    "apellidos" => $user["apellidos"],
    "username"  => $user["username"],
    "tipo_user" => $user["tipo_user"]
];
