<?php

use App\Config\Encriptar;
use App\Models\Google\GoogleApi;
use App\Models\SessionModel;
use App\Models\Usuarios;
use App\Router\HttpData;
use App\Session\SessionManager; // <-- Añadir esta línea

$correo   = HttpData::post("username");
$password = HttpData::post("password");



$user    = Usuarios::getUser("username", $correo);
$captcha = HttpData::post("captcha");

$captcha_valid = GoogleApi::verifyRecaptcha($captcha, 'login');
if (!$captcha_valid['status']) die(json_encode($captcha_valid, JSON_UNESCAPED_UNICODE));

if (!$user) {
    die(json_encode([
        "status" => false,
        "response" => "warning",
        "text" => "Usuario o contraseña incorrectos",
    ]));
}

if (!Encriptar::verificar($password, $user["password"])) {
    die(json_encode([
        "status" => false,
        "response" => "warning",
        "text" => "Usuario o contraseña incorrectos",
    ]));
}

$session_user = [
    "id"        => $user["id"],
    "nombre"    => $user["nombre"],
    "apellidos" => $user["apellido"],
    "username"  => $user["username"],
    "rol"       => $user["rol"],
];

$USR = new Usuarios();
$USR->update(['ultimo_acceso' => date('Y-m-d H:i:s')], ['id' => $user['id']]);

// Iniciar y configurar la sesión
$sessionManager = new SessionManager(); // <-- Crear instancia
$sessionManager->setUserSession($session_user); // <-- Establecer datos de sesión
$sessionManager->regenerateSessionId(); // <-- Regenerar ID de sesión

$sessionModel = new SessionModel(); // Crear la sesión y obtener el token
$sessionResult = $sessionModel->crearSesion($session_user);


die(json_encode([
    "status" => true,
    "response" => "success",
    "text" => "Inicio de sesión exitoso. Sesión iniciada.", // <-- Mensaje actualizado
]));
