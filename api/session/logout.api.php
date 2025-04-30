<?php

use App\Models\SessionModel;

$SSM = new SessionModel();
$SSM->cerrarSesion();

die(json_encode(['status' => 'ok', 'message' => 'Sesión cerrada correctamente']));
