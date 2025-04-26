<?php

namespace App\Models;

use App\Database\Database;

class Usuarios extends BaseModel
{
    public function __construct()
    {
        $this->DataBase = new Database();
        $this->table = 'usuarios';
        $this->filter("eliminado", "!=", 1);
    }

    static function getUser($campo, $valor)
    {
        $USR = new Usuarios();
        return $USR->getToAttr($campo, $valor);
    }
}
