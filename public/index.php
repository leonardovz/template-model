<?php

use App\Config\Config;
use App\Models\FileLoader;

Config::timezone();

require_once '../app/controller.php';

$loader = new FileLoader('../');
$loader->cargar('router/router');
