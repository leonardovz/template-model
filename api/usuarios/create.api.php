<?php

use App\Config\Encriptar;
use App\Models\Functions;
use App\Models\Usuarios;
use App\Router\HttpData;


$username   = HttpData::post("username") ?? null;
$correo     = HttpData::post("correo")   ?? null;
$nombre     = HttpData::post("nombre")   ?? null;
$apellido   = HttpData::post("apellido") ?? null;
$rol        = HttpData::post("rol")      ?? null;
$estado     = HttpData::post("estado")   ?? 'usuario';


// Validate and sanitize input fields
$required_fields = ['username', 'correo', 'nombre', 'apellido', 'rol', 'estado'];

$errors = [];
foreach ($required_fields as $field) {
    if (empty($$field)) {
        $errors[] = "El campo $field es requerido";
    } else {
        // Sanitize input to prevent SQL injection
        $$field = filter_var($$field, FILTER_SANITIZE_STRING);
        $$field = htmlspecialchars($$field, ENT_QUOTES, 'UTF-8');
    }
}

if (!empty($errors)) {
    die(json_encode([
        'status'    => false,
        'response'  => 'error',
        'text'      => "Todos los campos son requeridos",
        'errors'    => $errors,
    ]));
}

if (Usuarios::getUser('username', $username)) {
    die(json_encode([
        'status'    => false,
        'response'  => 'error',
        'text'      => "El usuario ya existe",
    ]));
}
if (Usuarios::getUser('correo', $correo)) {
    die(json_encode([
        'status'    => false,
        'response'  => 'error',
        'text'      => "El correo ya existe",
    ]));
}

$pwd = Functions::generatePassword(8);
$password = Encriptar::encriptar($pwd);
$username = strtolower(Functions::removeSpecialChars($username));


$data = [
    'username' => $username,
    'correo'   => strtolower($correo),
    'nombre'   => $nombre,
    'apellido' => $apellido,
    'password' => $password,
    'rol'      => $rol,
    'estado'   => $estado,
];


$res = [
    'status'   => true,
    'response' => 'success',
    'text'     => 'Usuario creado con éxito'
];

$USR = new Usuarios();
if ($id = $USR->create($data)) {
    $res = [
        'status'   => true,
        'response' => 'success',
        'text'     => 'Usuario creado con éxito',
        'data'     => ['pwd' => $pwd, 'username' => $username]
    ];
} else {
    $res = [
        'status'   => false,
        'response' => 'error',
        'text'     => 'Error al crear el usuario'
    ];
}

die(json_encode($res, JSON_UNESCAPED_UNICODE));
