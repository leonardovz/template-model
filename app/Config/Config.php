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
}
