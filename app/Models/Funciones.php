<?php


namespace App\Models;

class Functions
{
    public static function normalizePath(string $path): string
    {
        return '/' . trim($path, '/');
    }
}
