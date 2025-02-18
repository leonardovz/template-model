<?php

namespace App\Router;

class HttpData
{
    /**
     * Obtiene un valor de la superglobal $_POST.
     *
     * @param string $key La clave del valor a obtener.
     * @param mixed $default Valor por defecto si la clave no existe.
     * @return mixed El valor sanitizado o el valor por defecto.
     */
    public static function post($key, $default = null)
    {
        return self::sanitize($_POST[$key] ?? $default);
    }

    /**
     * Obtiene un valor de la superglobal $_GET.
     *
     * @param string $key La clave del valor a obtener.
     * @param mixed $default Valor por defecto si la clave no existe.
     * @return mixed El valor sanitizado o el valor por defecto.
     */
    public static function get($key, $default = null)
    {
        return self::sanitize($_GET[$key] ?? $default);
    }

    /**
     * Obtiene un archivo enviado mediante $_FILES.
     *
     * @param string $key La clave del archivo a obtener.
     * @return array|null El array del archivo o null si no existe.
     */
    public static function file($key)
    {
        return $_FILES[$key] ?? null;
    }

    /**
     * Sanitiza un valor para evitar inyecciones XSS u otros problemas de seguridad.
     *
     * @param mixed $value El valor a sanitizar.
     * @return mixed El valor sanitizado.
     */
    private static function sanitize($value)
    {
        if (is_array($value)) {
            return array_map('self::sanitize', $value);
        }
        return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
    }

    /**
     * Obtiene todos los valores de $_POST.
     *
     * @return array Todos los valores de $_POST sanitizados.
     */
    public static function allPost()
    {
        return self::sanitize($_POST);
    }

    /**
     * Obtiene todos los valores de $_GET.
     *
     * @return array Todos los valores de $_GET sanitizados.
     */
    public static function allGet()
    {
        return self::sanitize($_GET);
    }

    /**
     * Obtiene todos los archivos enviados mediante $_FILES.
     *
     * @return array Todos los archivos de $_FILES.
     */
    public static function allFiles()
    {
        return $_FILES;
    }
}
