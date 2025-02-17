<?php

// Cargar controladores externos

use App\Models\FileLoader;

require_once '../app/controller.php';


$loader = new FileLoader('../');
$loader->cargar('router/router');
