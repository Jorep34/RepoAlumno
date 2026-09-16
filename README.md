# EduGestión - Aplicativo de Gestión de Alumnos

Aplicativo web desarrollado en PHP + MySQL para registrar y consultar alumnos.

## Datos de conexión

- Host: mysql-jojoapp.alwaysdata.net
- Usuario: jojoapp
- Base de datos: jojoapp_alumnosdb

La contraseña se encuentra configurada en `config.php`.

## Instalación en AlwaysData

1. Sube todos los archivos de este proyecto al espacio web mediante FileZilla.
2. Verifica que `index.php`, `config.php` y `style.css` queden en la carpeta pública de tu sitio.
3. Abre la dirección de tu página, por ejemplo:
   `http://jojoapp.alwaysdata.net/index.php`
4. Al cargar la aplicación, `config.php` crea automáticamente la tabla `alumnos` si todavía no existe.
5. No necesitas ejecutar un SQL manual para crear la tabla.

## Estructura

- `index.php`: interfaz web, registro, listado y eliminación.
- `config.php`: conexión MySQL y creación automática de la tabla.
- `style.css`: diseño visual responsive.
- `README.md`: documentación.

## Tabla creada

```sql
CREATE TABLE IF NOT EXISTS alumnos (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(120) NOT NULL,
    identificacion VARCHAR(50) NOT NULL UNIQUE,
    telefono VARCHAR(30) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

## Funciones

- Registrar alumnos.
- Mostrar alumnos registrados.
- Eliminar alumnos.
- Validar campos obligatorios.
- Evitar identificaciones duplicadas.
- Crear la tabla automáticamente.
- Diseño responsive para computador y móvil.

## Nota sobre imágenes

La portada utiliza una imagen de Unsplash mediante enlace externo para darle una presentación profesional. Si el servidor bloquea recursos externos, la aplicación seguirá funcionando; únicamente no se mostrará esa imagen.
