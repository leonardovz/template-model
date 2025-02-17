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

            'driver'   => 'mysql', // mysql(MySql) || pgsql (PostgreSQL)
            'host'     => '',
            'dbname'   => '',
            'user'     => '',
            'password' => '',
        ];
    }
}
