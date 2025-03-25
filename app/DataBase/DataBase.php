<?php

namespace App\Database;

use PDO;
use PDOException;
use App\Config\Config;

class Database
{
    private PDO $connection;

    public function __construct()
    {
        $this->connect();
    }
    public function conexion()
    {
        return $this->connection;
    }
    // Función para establecer la conexión con la base de datos
    private function connect(): void
    {
        try {
            $config = Config::conexionDB(); // Obtener configuración desde Config

            if ($config['driver'] === 'pgsql') {
                $dsn = "pgsql:host={$config['host']};port={$config['port']};dbname={$config['dbname']}";
            } elseif ($config['driver'] === 'mysql') {
                $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
            } else {
                throw new PDOException("Driver de base de datos no soportado");
            }

            $this->connection = new PDO($dsn, $config['user'], $config['password'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
            ]);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }

    // Obtener todas las filas de una consulta
    public function fetchAll(string $query, array $params = []): array
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    // Obtener una sola fila
    public function fetchOne(string $query, array $params = []): ?array
    {
        $stmt = $this->connection->prepare($query);
        $stmt->execute($params);
        return $stmt->fetch() ?: null;
    }

    // Insertar datos en la base de datos
    public function insert(string $query, array $params = []): bool
    {
        $stmt = $this->connection->prepare($query);
        return $stmt->execute($params);
    }

    // Actualizar datos en la base de datos
    public function update(string $query, array $params = []): bool
    {
        $stmt = $this->connection->prepare($query);
        return $stmt->execute($params);
    }

    // Obtener la última ID insertada
    public function lastInsertId(): string
    {
        return $this->connection->lastInsertId();
    }
}

// Uso de la clase
// $db = new Database();
// $usuarios = $db->fetchAll("SELECT * FROM usuarios");
// $usuario = $db->fetchOne("SELECT * FROM usuarios WHERE id = ?", [1]);
// $db->insert("INSERT INTO usuarios (nombre, email) VALUES (?, ?)", ['Juan', 'juan@email.com']);
// $db->update("UPDATE usuarios SET nombre = ? WHERE id = ?", ['Pedro', 1]);