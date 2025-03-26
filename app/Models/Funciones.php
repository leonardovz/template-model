<?php


namespace App\Models;

class Functions
{
    public static function normalizePath(string $path): string
    {
        return '/' . trim($path, '/');
    }
    public static function generatePassword(int $length = 12): string
    {
        $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789.#@$';
        $password = '';
        for ($i = 0; $i < $length; $i++) {
            $password .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $password;
    }
    public static function removeSpecialChars(string $text): string
    {
        return preg_replace('/[^a-zA-Z0-9.]/', '', $text);
    }
}
