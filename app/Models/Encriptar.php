<?php

namespace App\Config;

class Encriptar
{
    /**
     * Utilize { PASSWORD_ARGON2ID } en password_hash si tiene buen procesamiento
     */
    static function encode()
    {
        return 'm0decrypt'; //Clave de encriptado
    }

    static function encriptar($pwd)
    {
        $preparado = hash_hmac("sha256", $pwd, self::encode()); //Encripta una ves
        return  password_hash($preparado, PASSWORD_BCRYPT, ['cost' => 10]); //Refuerza el encriptado con un coste medio
    }
    static function verificar($pwd, $pwd_hashed)
    {
        $preparado = hash_hmac("sha256", $pwd, self::encode()); //codifica, y decodifica
        return password_verify($preparado, $pwd_hashed); //Devuelve true o false, si el texto coincide, no se desincripta
    }
}
