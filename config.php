<?php
// Configuración de conexión a MySQL - AlwaysData
$host = "mysql-jojoapp.alwaysdata.net";
$user = "jojoapp";
$password = "3108787231Jc.";
$database = "jojoapp_alumnosdb";

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Error de conexión a la base de datos: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

// Crear tabla automáticamente si no existe
$sql = "CREATE TABLE IF NOT EXISTS alumnos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    identificacion VARCHAR(50) NOT NULL UNIQUE,
    telefono VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

if (!$conn->query($sql)) {
    die("Error al crear la tabla alumnos: " . $conn->error);
}
?>