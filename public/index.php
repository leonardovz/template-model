<?php

use App\Config\Config;
use App\Models\FileLoader;


require_once '../app/controller.php';

Config::timezone();

$loader = new FileLoader('../');
$loader->cargar('router/router');
