<?php

use App\Models\FileLoader;

require_once 'Models/FileLoader.php';

$CLoader = new FileLoader();

$CLoader->cargar('Config/Config');
$CLoader->cargar('Router/Router');
$CLoader->cargar('Router/HttpData');

$CLoader->cargar('Session/Session');
