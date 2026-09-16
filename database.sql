-- Base de datos: jojoapp_alumnosdb
-- La aplicación crea la tabla automáticamente al ejecutarse.
-- Este archivo es opcional para documentar la estructura.

CREATE TABLE IF NOT EXISTS alumnos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    identificacion VARCHAR(50) NOT NULL UNIQUE,
    telefono VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
