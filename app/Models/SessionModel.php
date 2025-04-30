<?php

namespace App\Models;

use App\Config\Encriptar;
use App\Database\Database;
use App\Session\SessionManager;

class SessionModel extends BaseModel
{
    private $sessionManager;
    private $tokenExpiration = 86400; // 24 horas en segundos

    public function __construct()
    {
        $this->DataBase = new Database();
        $this->sessionManager = new SessionManager();
        $this->table = 'sesiones'; // Asumiendo que existe o crearás esta tabla
    }

    /**
     * Crea una nueva sesión y genera un token de acceso
     * 
     * @param array $userData Datos del usuario para la sesión
     * @return array Información de la sesión creada con token
     */
    public function crearSesion($userData)
    {
        // Verificar si ya existe una sesión activa para este usuario
        $this->cerrarSesionesAnteriores($userData['id']);

        // Generar token único
        $token = $this->generarToken($userData);

        // Datos para guardar en la tabla de sesiones
        $sessionData = [
            'usuario_id'       => $userData['id'],
            'token'            => $token,
            'ip_address'       => Functions::obtenerIP(),
            'user_agent'       => $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown',
            'fecha_creacion'   => date('Y-m-d H:i:s'),
            'fecha_expiracion' => date('Y-m-d H:i:s', time() + $this->tokenExpiration),
            'activa'           => 1
        ];

        // Guardar en la base de datos
        $sessionId = $this->create($sessionData);

        if ($sessionId) {
            // Establecer la sesión en PHP
            $this->sessionManager->setUserSession($userData);
            $this->sessionManager->regenerateSessionId();

            // Guardar el token en la sesión
            $_SESSION['token'] = $token;

            return [
                'status' => true,
                'token' => $token,
                'expira' => $sessionData['fecha_expiracion'],
                'session_id' => $sessionId
            ];
        }

        return [
            'status' => false,
            'mensaje' => 'Error al crear la sesión'
        ];
    }

    /**
     * Genera un token único para la sesión
     * 
     * @param array $userData Datos del usuario
     * @return string Token generado
     */
    private function generarToken($userData)
    {
        $base = $userData['id'] . $userData['username'] . time() . rand(1000, 9999);
        return hash('sha256', $base);
    }

    /**
     * Verifica si un token es válido
     * 
     * @param string $token Token a verificar
     * @return bool|array False si no es válido, datos de la sesión si es válido
     */
    public function verificarToken($token = null)
    {
        if ($token === null && isset($_SESSION['token'])) $token = $_SESSION['token'];


        $sesion = $this->DataBase->fetchOne(
            "SELECT * FROM {$this->table} WHERE token = ? AND activa = true AND fecha_expiracion > NOW()",
            [$token]
        );

        if (!$sesion) return false;

        return $sesion;
    }

    /**
     * Cierra una sesión específica
     * 
     * @param int $sessionId ID de la sesión a cerrar
     * @return bool Resultado de la operación
     */
    public function cerrarSesion($sessionId = null)
    {
        if ($sessionId === null && isset($_SESSION['token'])) {
            // Cerrar la sesión actual
            $token = $_SESSION['token'];
            $result = $this->update(['activa' => 0], ['token' => $token]);
            $this->sessionManager->logout();
            return $result;
        } elseif ($sessionId !== null) {
            // Cerrar una sesión específica por ID
            return $this->update(['activa' => 0], ['id' => $sessionId]);
        }

        return false;
    }

    /**
     * Cierra todas las sesiones anteriores de un usuario
     * 
     * @param int $userId ID del usuario
     * @return bool Resultado de la operación
     */
    public function cerrarSesionesAnteriores($userId)
    {
        return $this->DataBase->update(
            "UPDATE {$this->table} SET activa = false WHERE usuario_id = ? AND activa = true",
            [$userId]
        );
    }

    /**
     * Verifica si un usuario tiene permiso para acceder a un recurso
     * 
     * @param string $recurso Recurso a verificar
     * @param string $rol Rol del usuario
     * @return bool Si tiene acceso o no
     */
    public function verificarAcceso($recurso, $rol)
    {
        // Implementación básica de control de acceso basado en roles
        // Esto podría expandirse para usar una tabla de permisos más detallada

        $permisos = [
            'admin' => ['*'], // Acceso total
            'vendedor' => ['ventas', 'clientes', 'productos'],
            'usuario' => ['perfil', 'productos']
        ];

        if (!isset($permisos[$rol])) {
            return false;
        }

        // Si el rol tiene acceso a todo
        if (in_array('*', $permisos[$rol])) {
            return true;
        }

        // Verificar si el recurso está en la lista de permisos del rol
        return in_array($recurso, $permisos[$rol]);
    }

    /**
     * Registra actividad del usuario
     * 
     * @param int $userId ID del usuario
     * @param string $accion Acción realizada
     * @param string $detalles Detalles adicionales
     * @return bool Resultado del registro
     */
    public function registrarActividad($userId, $accion, $detalles = '')
    {
        // Asumiendo que existe una tabla 'actividad_usuarios'
        return $this->DataBase->insert(
            "INSERT INTO actividad_usuarios (usuario_id, accion, detalles, fecha) VALUES (?, ?, ?, NOW())",
            [$userId, $accion, $detalles]
        );
    }

    /**
     * Renueva un token de sesión
     * 
     * @param string $token Token actual
     * @return array Resultado con nuevo token si es exitoso
     */
    public function renovarToken($token)
    {
        $sesion = $this->verificarToken($token);

        if (!$sesion) {
            return [
                'status' => false,
                'mensaje' => 'Token inválido o expirado'
            ];
        }

        // Obtener datos del usuario
        $usuario = Usuarios::getUser('id', $sesion['usuario_id']);

        if (!$usuario) {
            return [
                'status' => false,
                'mensaje' => 'Usuario no encontrado'
            ];
        }

        // Generar nuevo token
        $nuevoToken = $this->generarToken([
            'id' => $usuario['id'],
            'username' => $usuario['username']
        ]);

        // Actualizar en la base de datos
        $fechaExpiracion = date('Y-m-d H:i:s', time() + $this->tokenExpiration);
        $actualizado = $this->update(
            [
                'token' => $nuevoToken,
                'fecha_expiracion' => $fechaExpiracion
            ],
            ['id' => $sesion['id']]
        );

        if ($actualizado) {
            // Actualizar token en la sesión actual si corresponde
            if (isset($_SESSION['token']) && $_SESSION['token'] === $token) {
                $_SESSION['token'] = $nuevoToken;
            }

            return [
                'status' => true,
                'token' => $nuevoToken,
                'expira' => $fechaExpiracion
            ];
        }

        return [
            'status' => false,
            'mensaje' => 'Error al renovar el token'
        ];
    }
}
