<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Principal</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Plataforma Streaming</a>
    <div class="d-flex">
        <span class="navbar-text me-3">Hola, <?php echo $_SESSION['admin_nombre']; ?></span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Salir</a>
    </div>
  </div>
</nav>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center mb-4">
                <div class="card-body">
                    <h5 class="card-title">Gestión de Películas</h5>
                    <p class="card-text">Registrar y consultar catálogo.</p>
                    <a href="peliculas.php" class="btn btn-primary">Ir a Películas</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center mb-4">
                <div class="card-body">
                    <h5 class="card-title">Gestión de Clientes</h5>
                    <p class="card-text">Ver usuarios de la App Móvil.</p>
                    <a href="clientes.php" class="btn btn-success">Ir a Clientes</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card text-center mb-4">
                <div class="card-body">
                    <h5 class="card-title">Usuarios Administrativos</h5>
                    <p class="card-text">Control de acceso web.</p>
                    <a href="usuarios.php" class="btn btn-warning">Ir a Usuarios</a>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>