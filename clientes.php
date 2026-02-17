<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
include 'conexion.php';

$mensaje = "";

// --- 1. LÓGICA DE REGISTRO (POST) ---
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['registrar'])) {
    $nombre = $con->real_escape_string($_POST['nombre']);
    $apellidos = $con->real_escape_string($_POST['apellidos']);
    $correo = $con->real_escape_string($_POST['correo']);
    $password = $_POST['password']; // En producción deberías usar password_hash()

    // Verificamos si el correo ya existe
    $check = $con->query("SELECT id FROM clientes WHERE correo = '$correo'");
    if ($check->num_rows > 0) {
        $mensaje = "<div class='alert alert-warning'>El correo ya está registrado.</div>";
    } else {
        $sql = "INSERT INTO clientes (nombre, apellidos, correo, password, estatus) VALUES ('$nombre', '$apellidos', '$correo', '$password', 1)";
        if ($con->query($sql)) {
            $mensaje = "<div class='alert alert-success'>Cliente registrado correctamente.</div>";
        } else {
            $mensaje = "<div class='alert alert-danger'>Error: " . $con->error . "</div>";
        }
    }
}

// --- 2. LÓGICA DE ELIMINAR / ACTIVAR (GET) ---
if (isset($_GET['id']) && isset($_GET['accion'])) {
    $id = intval($_GET['id']);
    
    if ($_GET['accion'] == 'eliminar') {
        $con->query("DELETE FROM clientes WHERE id = $id");
        $mensaje = "<div class='alert alert-info'>Cliente eliminado.</div>";
    } elseif ($_GET['accion'] == 'activar') {
        $con->query("UPDATE clientes SET estatus = 1 WHERE id = $id");
    } elseif ($_GET['accion'] == 'desactivar') {
        $con->query("UPDATE clientes SET estatus = 0 WHERE id = $id");
    }
    // Redirección limpia para evitar reenvío de formularios
    // header("Location: clientes.php"); // Descomenta esto si te molesta el refresh
}

// --- 3. CONSULTA ---
$clientes = $con->query("SELECT * FROM clientes ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body class="bg-light">

<nav class="navbar navbar-dark bg-success mb-4">
    <div class="container">
        <span class="navbar-brand">Administración de Clientes</span>
        <a href="menu.php" class="btn btn-outline-light btn-sm">Volver al Menú</a>
    </div>
</nav>

<div class="container">
    <?php echo $mensaje; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white"><strong>Registrar Nuevo Cliente</strong></div>
        <div class="card-body">
            <form method="POST" action="" class="row g-3">
                <div class="col-md-6">
                    <label>Nombre</label>
                    <input type="text" name="nombre" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Clave (Password)</label>
                    <input type="text" name="password" class="form-control" required placeholder="Ej: y76qwer">
                </div>
                <div class="col-md-6">
                    <label>Apellidos</label>
                    <input type="text" name="apellidos" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Correo Electrónico</label>
                    <input type="email" name="correo" class="form-control" required>
                </div>
                <div class="col-12 text-end">
                    <button type="submit" name="registrar" class="btn btn-primary">Registrar</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-white"><strong>Listado de Clientes</strong></div>
        <div class="card-body p-0">
            <table class="table table-bordered table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Nombre Completo</th>
                        <th>Correo / Usuario</th>
                        <th>Password (Visible por urgencia)</th>
                        <th>Estatus</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($fila = $clientes->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $fila['nombre'] . " " . $fila['apellidos']; ?></td>
                        <td><?php echo $fila['correo']; ?></td>
                        <td><?php echo $fila['password']; ?></td>
                        <td>
                            <?php echo ($fila['estatus'] == 1) ? '<span class="badge bg-success">Activo</span>' : '<span class="badge bg-danger">Inactivo</span>'; ?>
                        </td>
                        <td>
                            <a href="clientes.php?accion=eliminar&id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Seguro?');">Eliminar</a>
                            
                            <?php if($fila['estatus'] == 0): ?>
                                <a href="clientes.php?accion=activar&id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-primary">Activar</a>
                            <?php else: ?>
                                <a href="clientes.php?accion=desactivar&id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-secondary">Desactivar</a>
                            <?php endif; ?>
                            
                            <button class="btn btn-sm btn-warning" disabled>Actualizar</button>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>