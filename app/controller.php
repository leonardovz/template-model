<?php

use App\Models\FileLoader;

require_once 'Models/FileLoader.php';

(function () {
    $loader = new FileLoader();

    $loader->cargar('Config/Config');
    $loader->cargar('Router/Router');


    /** */
})();
