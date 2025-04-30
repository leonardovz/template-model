<?php

use App\Session\SessionManager;

$session = new SessionManager();
$session->logout();


die(json_encode(['status' => 'ok', 'message' => 'Sesión cerrada correctamente']));
