# Proyecto de Router y Base de Datos con PHP y POO

## 📌 Descripción
Este proyecto implementa un sistema de **ruteo dinámico** y una **clase de conexión a base de datos** usando **PHP y POO (Programación Orientada a Objetos)**. Se admite tanto **MySQL** como **PostgreSQL**, permitiendo cambiar el motor de base de datos fácilmente desde la configuración.

## 🚀 Características
### ✅ **Router Dinámico**
- Permite definir rutas con parámetros `{}` (Ejemplo: `/usuarios/{id}`).
- Soporte para rutas wildcard `{any}` para capturar subrutas dinámicas.
- Soporte para `GET` y `POST`.
- Middleware para proteger rutas.
- Tipos de respuesta: `JSON`, `VIEW`, `REDIRECT`.

### ✅ **Conexión a Base de Datos con PDO**
- Soporte para **MySQL** y **PostgreSQL**.
- Métodos para **obtener múltiples filas**, **una fila**, **insertar** y **actualizar** datos.
- Se obtiene la configuración desde `Config::getDatabaseConfig()`.
- Manejador de errores y excepciones con `PDOException`.

## 📂 Estructura del Proyecto
```
/app
  ├── Router.php  # Sistema de rutas
  ├── Database.php  # Conexión PDO
  ├── Config.php  # Configuración
  ├── Controllers/
  ├── Models/
  ├── Views/
/public
  ├── index.php  # Punto de entrada
  ├── assets/
```

## 🛠️ Instalación y Configuración
### 🔹 **1. Clonar el repositorio**
```sh
git clone https://github.com/usuario/proyecto.git
cd proyecto
```

### 🔹 **2. Configurar Base de Datos**
Modifica `Config.php` para definir el tipo de base de datos que deseas usar:
```php
public static function getDatabaseConfig() {
    return [
        'driver' => 'mysql', // Cambia a 'pgsql' si usas PostgreSQL
        'host' => 'localhost',
        'port' => '5432',
        'dbname' => 'mi_base',
        'user' => 'usuario',
        'password' => 'contraseña'
    ];
}
```

### 🔹 **3. Instalación de Dependencias (Opcional)**
Si usas `composer`, instala dependencias con:
```sh
composer install
```

## 🏗️ Uso del Proyecto
### 🔸 **Definir Rutas**
```php
$router->get('/usuarios/{id}', function($id) {
    return ["usuario" => "Usuario con ID $id"];
}, 'json');
```

### 🔸 **Ejecutar Consultas en la Base de Datos**
```php
$db = new Database();
$usuarios = $db->fetchAll("SELECT * FROM usuarios");
$usuario = $db->fetchOne("SELECT * FROM usuarios WHERE id = ?", [1]);
$db->insert("INSERT INTO usuarios (nombre, email) VALUES (?, ?)", ['Juan', 'juan@email.com']);
$db->update("UPDATE usuarios SET nombre = ? WHERE id = ?", ['Pedro', 1]);
```

## 📌 Notas
- Asegúrate de que `mod_rewrite` esté habilitado si usas Apache.
- Si usas PostgreSQL, asegúrate de que la extensión `pdo_pgsql` esté habilitada.

## 📜 Licencia
Este proyecto es de código abierto bajo la licencia MIT.

---

🚀 **¡Listo para usar! Si necesitas más personalización, contáctanos.**

