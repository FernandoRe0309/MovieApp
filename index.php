<?php
session_start();
include 'conexion.php';

// Si ya está logueado, lo mandamos al menú
if (isset($_SESSION['admin_id'])) {
    header("Location: menu.php");
    exit();
}

// Lógica de Login
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    // Consulta simple (Insegura para producción, perfecta para prototipo escolar rápido)
    $sql = "SELECT * FROM usuarios_admin WHERE usuario = '$usuario' AND password = '$password'";
    $result = $con->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['admin_id'] = $row['id'];
        $_SESSION['admin_nombre'] = $row['nombre'];
        header("Location: menu.php"); // ¡Éxito!
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Streaming Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f4f4f4; display: flex; align-items: center; justify-content: center; height: 100vh; }
        .login-card { width: 100%; max-width: 400px; padding: 20px; background: white; border-radius: 10px; shadow: 0 4px 6px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<div class="login-card shadow">
    <h3 class="text-center mb-4">Inicio de Sesión</h3>
    
    <?php if(isset($error)): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" action="">
        <div class="mb-3">
            <label>Usuario</label>
            <input type="text" name="usuario" class="form-control" required placeholder="admin">
        </div>
        <div class="mb-3">
            <label>Contraseña</label>
            <input type="password" name="password" class="form-control" required placeholder="1234">
        </div>
        <button type="submit" class="btn btn-primary w-100">Ingresar</button>
    </form>
</div>

</body>
</html>