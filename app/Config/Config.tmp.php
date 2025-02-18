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
}
