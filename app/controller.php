<?php

use App\Models\FileLoader;

require_once 'Models/FileLoader.php';

$CLoader = new FileLoader();

$CLoader->cargar('Config/Config');
$CLoader->cargar('Router/Router');
$CLoader->cargar('Router/HttpData');

$CLoader->cargar('Session/Session');

$CLoader->cargar('Template/Template');
$CLoader->cargar('Template/AdminKit/Footer');
$CLoader->cargar('Template/AdminKit/NavBar');
$CLoader->cargar('Template/AdminKit/NavBarLeft');
$CLoader->cargar('Template/AdminKit/NavMenu');

$CLoader->cargar('DataBase/DataBase');
$CLoader->cargar('DataBase/BaseModel');

$CLoader->cargar('Models/Funciones');
$CLoader->cargar('Models/Encriptar');

$CLoader->cargar('Models/Usuarios');

$CLoader->cargar('Models/Google/GoogleApi');
