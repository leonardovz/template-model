<?php

use App\Config\Encriptar;
use App\Models\Usuarios;
use App\Router\HttpData;


$id        = HttpData::post('id');
$username  = HttpData::post('username');
$correo    = HttpData::post('correo');
$nombre    = HttpData::post('nombre');
$apellido  = HttpData::post('apellido');
$rol       = HttpData::post('rol');
$estado    = HttpData::post('estado');
$password  = HttpData::post('password');
$eliminado = HttpData::post('eliminado');

$update = [];

$USR = new Usuarios();
$usuario = $USR->getToAttr('id', $id);

if (!$usuario) {
    die(json_encode([
        'status' => false,
        'response' => 'warning',
        'text' => 'Ocurrio un error al buscar el usuario'
    ]));
}

if ($username !== null) $update['username'] = $username;
if ($correo   !== null) $update['correo']   = $correo;
if ($nombre   !== null) $update['nombre']   = $nombre;
if ($apellido !== null) $update['apellido'] = $apellido;
if ($rol      !== null) $update['rol']      = $rol;
if ($estado   !== null) $update['estado']   = $estado;
if ($password !== null) $update['password'] = Encriptar::encriptar($password);


if (!empty($update)) $update['updated_at'] = date('Y-m-d H:i:s');

if ($eliminado !== null) {
    $update['eliminado'] = (int)$eliminado;
}

if ($USR->update($update, ['id' => $id])) {
    $res = [
        'status' => true,
        'response' => 'success',
        'text' => 'Se actualizo correctamente el usuario',
    ];
} else {
    $res = [
        'status' => false,
        'response' => 'warning',
        'text' => 'Ocurrio un error al actualizar el usuario'
    ];
}

die(json_encode($res, JSON_UNESCAPED_UNICODE));
