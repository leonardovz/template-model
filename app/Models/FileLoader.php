<?php

namespace App\Models;

class FileLoader
{
    private string $basePath;

    public function __construct(string $basePath = __DIR__ . '/../../app/')
    {

        $this->basePath = realpath($basePath) . DIRECTORY_SEPARATOR;
    }

    public function cargar(string $ruta): void
    {
        $filePath = realpath($this->basePath . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $ruta) . '.php');

        if ($filePath && file_exists($filePath) && strpos($filePath, $this->basePath) === 0) {
            require_once $filePath;
        } else {
            http_response_code(404);
            echo json_encode(["error" => "Archivo no encontrado"]);
        }
    }
}
