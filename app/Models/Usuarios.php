<?php

namespace App\Models;

use App\Database\Database;

class Usuarios extends BaseModel
{
    static function getUser($campo, $valor)
    {
        $db = new Database();
        $sql = "SELECT * FROM usuarios WHERE $campo = :valor";
        $params = [":valor" => $valor];
        return $db->fetchOne($sql, $params);
    }
}
