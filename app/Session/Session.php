<?php

class SessionManager
{
    // Iniciar la sesión si no está iniciada
    public function __construct()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }

    // Establecer datos de usuario en la sesión después de un login exitoso
    public function setUserSession($userData)
    {
        if (is_array($userData)) {
            $_SESSION['user'] = $userData;
            $_SESSION['logged_in'] = true;
        } else {
            throw new Exception("Los datos del usuario deben ser un array.");
        }
    }

    // Verificar si el usuario está logueado
    public function isLoggedIn()
    {
        return isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;
    }

    // Obtener datos del usuario desde la sesión
    public function getUserData($key = null)
    {
        if ($this->isLoggedIn()) {
            if ($key === null) {
                return $_SESSION['user'];
            } else {
                return isset($_SESSION['user'][$key]) ? $_SESSION['user'][$key] : null;
            }
        }
        return null;
    }

    // Cerrar sesión y destruir la sesión
    public function logout()
    {
        // Limpiar los datos de la sesión
        $_SESSION = array();

        // Destruir la sesión
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }

        session_destroy();
    }

    // Regenerar el ID de la sesión para prevenir fijación de sesión
    public function regenerateSessionId()
    {
        session_regenerate_id(true);
    }
}

// Ejemplo de uso
try {
    $session = new SessionManager();

    // Simular un login exitoso
    $userData = [
        'id' => 1,
        'username' => 'john_doe',
        'email' => 'john@example.com'
    ];

    $session->setUserSession($userData);

    // Verificar si el usuario está logueado
    if ($session->isLoggedIn()) {
        echo "Usuario logueado: " . $session->getUserData('username');
    }

    // Cerrar sesión
    $session->logout();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
