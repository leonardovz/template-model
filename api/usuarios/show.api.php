<?php

use App\Models\Usuarios;




$USR = new Usuarios();

$data = $USR->mostrar();

$res = [
    'status'    => true,
    'response'  => 'success',
    'text'      => 'Datos encontrados',
    'data'      => $data
];


die(json_encode($res, JSON_UNESCAPED_UNICODE));
