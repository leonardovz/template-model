<?php

namespace App\Config;

class Config
{
    static public function proyect(): string
    {
        return '/template';
    }
    static public function conexionDB(): array
    {
        return [
            'driver'   => 'mysql', // Cambia a 'pgsql' si usas PostgreSQL
            'host'     => 'localhost',
            'port'     => '5432',
            'dbname'   => 'mi_base',
            'user'     => 'usuario',
            'password' => 'contraseña'
        ];
    }

    static public function timezone(): void
    {
        date_default_timezone_set('America/Mexico_City');
    }
    static function version()
    {
        return "1.0.2";
    }

    static function http_protocol()
    {
        return ((!isset(($_SERVER['HTTPS'])) || $_SERVER['HTTPS'] != 'on') ? 'http://' : "https://");
    }
    static function RUTA()
    {
        return self::http_protocol() .  $_SERVER['HTTP_HOST'] . self::proyect() . '/';
    }
    static function relative_uri()
    {
        return self::http_protocol() .  $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    }
    static function route()
    {
        return self::proyect();
    }
    static function debug_errors()
    {
        // if (self::getDevelop_mode() == 'off') return;

        ini_set('display_errors', '1');
        ini_set('display_startup_errors', '1');
        error_reporting(E_ALL);
    }
}
