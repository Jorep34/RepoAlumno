<?php
require_once "config.php";

$mensaje = "";
$error = "";

// Crear alumno
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion"]) && $_POST["accion"] === "crear") {
    $nombre = trim($_POST["nombre"] ?? "");
    $identificacion = trim($_POST["identificacion"] ?? "");
    $telefono = trim($_POST["telefono"] ?? "");

    if ($nombre === "" || $identificacion === "" || $telefono === "") {
        $error = "Todos los campos son obligatorios.";
    } else {
        $stmt = $conn->prepare("INSERT INTO alumnos (nombre, identificacion, telefono) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nombre, $identificacion, $telefono);

        if ($stmt->execute()) {
            $mensaje = "Alumno registrado correctamente.";
        } else {
            $error = ($stmt->errno == 1062)
                ? "La identificación ya está registrada."
                : "No fue posible registrar el alumno.";
        }
        $stmt->close();
    }
}

// Eliminar alumno
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["accion"]) && $_POST["accion"] === "eliminar") {
    $id = intval($_POST["id"] ?? 0);
    if ($id > 0) {
        $stmt = $conn->prepare("DELETE FROM alumnos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
        $mensaje = "Alumno eliminado correctamente.";
    }
}

$resultado = $conn->query("SELECT id, nombre, identificacion, telefono FROM alumnos ORDER BY id DESC");
$total = $resultado ? $resultado->num_rows : 0;
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduGestión | Gestión de Alumnos</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<header class="hero">
    <nav class="navbar">
        <div class="brand">
            <div class="brand-icon">🎓</div>
            <div>
                <strong>EduGestión</strong>
                <span>Panel académico</span>
            </div>
        </div>
        <a class="nav-link" href="#alumnos">Alumnos registrados</a>
    </nav>

    <div class="hero-content">
        <div class="hero-text">
            <span class="eyebrow">GESTIÓN ACADÉMICA</span>
            <h1>Administra tus alumnos de forma <span>simple y profesional.</span></h1>
            <p>Registra, consulta y administra la información de tus alumnos desde un panel moderno, rápido y fácil de usar.</p>
            <a class="hero-button" href="#registro">Registrar alumno <span>→</span></a>
        </div>
        <div class="hero-card">
            <img src="https://images.unsplash.com/photo-1523240795612-9a054b0db644?auto=format&fit=crop&w=900&q=85" alt="Estudiantes universitarios">
            <div class="image-caption">
                <div>
                    <small>ALUMNOS</small>
                    <strong><?= $total ?></strong>
                </div>
                <span>Registros activos</span>
            </div>
        </div>
    </div>
</header>

<main class="container">
    <?php if ($mensaje): ?>
        <div class="alert success">✓ <?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>
    <?php if ($error): ?>
        <div class="alert error">⚠ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <section class="stats">
        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div><span>Total de alumnos</span><strong><?= $total ?></strong></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🗂️</div>
            <div><span>Información gestionada</span><strong>100%</strong></div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔐</div>
            <div><span>Base de datos</span><strong>MySQL</strong></div>
        </div>
    </section>

    <section class="workspace">
        <div class="form-panel" id="registro">
            <div class="section-title">
                <span class="mini-label">NUEVO REGISTRO</span>
                <h2>Registrar alumno</h2>
                <p>Completa los datos para agregar un nuevo alumno.</p>
            </div>

            <form method="POST" autocomplete="off">
                <input type="hidden" name="accion" value="crear">

                <label for="nombre">Nombre completo</label>
                <div class="input-wrap">
                    <span>👤</span>
                    <input id="nombre" name="nombre" type="text" maxlength="120" placeholder="Ej. Carlos Jiménez" required>
                </div>

                <label for="identificacion">Identificación</label>
                <div class="input-wrap">
                    <span>🪪</span>
                    <input id="identificacion" name="identificacion" type="text" maxlength="50" placeholder="Ej. 1001234567" required>
                </div>

                <label for="telefono">Teléfono</label>
                <div class="input-wrap">
                    <span>📱</span>
                    <input id="telefono" name="telefono" type="tel" maxlength="30" placeholder="Ej. 300 123 4567" required>
                </div>

                <button class="primary-button" type="submit">Guardar alumno <span>→</span></button>
            </form>
        </div>

        <div class="table-panel" id="alumnos">
            <div class="table-header">
                <div>
                    <span class="mini-label">DIRECTORIO</span>
                    <h2>Alumnos registrados</h2>
                </div>
                <span class="count-badge"><?= $total ?> registro<?= $total == 1 ? "" : "s" ?></span>
            </div>

            <?php if ($resultado && $resultado->num_rows > 0): ?>
                <div class="table-scroll">
                    <table>
                        <thead>
                            <tr>
                                <th>Alumno</th>
                                <th>Identificación</th>
                                <th>Teléfono</th>
                                <th>Acción</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php while ($alumno = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td>
                                    <div class="student">
                                        <div class="avatar"><?= strtoupper(substr($alumno["nombre"], 0, 1)) ?></div>
                                        <strong><?= htmlspecialchars($alumno["nombre"]) ?></strong>
                                    </div>
                                </td>
                                <td><?= htmlspecialchars($alumno["identificacion"]) ?></td>
                                <td><?= htmlspecialchars($alumno["telefono"]) ?></td>
                                <td>
                                    <form method="POST" onsubmit="return confirm('¿Deseas eliminar este alumno?');">
                                        <input type="hidden" name="accion" value="eliminar">
                                        <input type="hidden" name="id" value="<?= (int)$alumno["id"] ?>">
                                        <button class="delete-button" type="submit">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="empty">
                    <div class="empty-icon">🎓</div>
                    <h3>Aún no hay alumnos</h3>
                    <p>Registra el primer alumno usando el formulario.</p>
                </div>
            <?php endif; ?>
        </div>
    </section>
</main>

<footer>
    <strong>EduGestión</strong> · Sistema de gestión de alumnos · PHP + MySQL
</footer>
</body>
</html>
<?php $conn->close(); ?>