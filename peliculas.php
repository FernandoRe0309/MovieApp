<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Películas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Ajuste para que las imágenes no rompan la tabla */
        .img-tabla { width: 50px; height: 70px; object-fit: cover; border-radius: 5px; }
        /* Botón flotante para móviles (opcional, estilo Material Design) */
        .btn-flotante { position: fixed; bottom: 20px; right: 20px; z-index: 100; border-radius: 50%; width: 60px; height: 60px; font-size: 30px; display: none; }
        @media (max-width: 768px) { .btn-flotante { display: block; } }
    </style>
</head>
<body class="bg-light pb-5"> <nav class="navbar navbar-dark bg-primary mb-3 shadow">
    <div class="container-fluid"> <span class="navbar-brand h1 mb-0">Admin Panel</span>
        <a href="menu.php" class="btn btn-sm btn-light text-primary fw-bold">Menú</a>
    </div>
</nav>

<div class="container-fluid px-3"> <?php echo $mensaje; ?>

    <div class="row">
        <div class="col-12 col-lg-4 mb-4">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold text-primary">
                    <i class="bi bi-plus-circle"></i> Nueva Película
                </div>
                <div class="card-body">
                    <form method="POST" action="" enctype="multipart/form-data">
                        <div class="mb-2">
                            <label class="form-label small text-muted">Título</label>
                            <input type="text" name="titulo" class="form-control" required placeholder="Ej: Titanic">
                        </div>
                        <div class="row">
                            <div class="col-6 mb-2">
                                <label class="form-label small text-muted">Género</label>
                                <select name="genero" class="form-select">
                                    <option value="Terror">Terror</option>
                                    <option value="Comedia">Comedia</option>
                                    <option value="Accion">Acción</option>
                                    <option value="Drama">Drama</option>
                                </select>
                            </div>
                            <div class="col-6 mb-2">
                                <label class="form-label small text-muted">Imagen</label>
                                <input type="file" name="imagen" class="form-control" accept="image/*" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small text-muted">Descripción</label>
                            <textarea name="descripcion" class="form-control" rows="2"></textarea>
                        </div>
                        <button type="submit" name="registrar" class="btn btn-primary w-100 fw-bold py-2">
                            Guardar Película
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-12 col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white fw-bold">
                    Catálogo
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle mb-0">
                            <thead class="table-secondary small">
                                <tr>
                                    <th>Img</th>
                                    <th>Info</th>
                                    <th class="d-none d-sm-table-cell">Género</th>
                                    <th class="text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result_peliculas->num_rows > 0): ?>
                                    <?php while($fila = $result_peliculas->fetch_assoc()): ?>
                                        <tr>
                                            <td style="width: 60px;">
                                                <img src="uploads/peliculas/<?php echo $fila['imagen']; ?>" class="img-tabla">
                                            </td>
                                            <td>
                                                <div class="fw-bold text-dark"><?php echo $fila['titulo']; ?></div>
                                                <div class="small">
                                                    <?php if($fila['estatus'] == 1): ?>
                                                        <span class="badge bg-success rounded-pill">Activa</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-danger rounded-pill">Inactiva</span>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="d-none d-md-block text-muted small text-truncate" style="max-width: 200px;">
                                                    <?php echo $fila['descripcion']; ?>
                                                </div>
                                            </td>
                                            <td class="d-none d-sm-table-cell small"><?php echo $fila['genero']; ?></td>
                                            
                                            <td class="text-center">
                                                <?php if($fila['estatus'] == 0): ?>
                                                    <a href="peliculas.php?accion=activar&id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-outline-success">
                                                        Activar
                                                    </a>
                                                <?php else: ?>
                                                    <a href="peliculas.php?accion=desactivar&id=<?php echo $fila['id']; ?>" class="btn btn-sm btn-outline-danger">
                                                        Baja
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr><td colspan="4" class="text-center py-4 text-muted">Sin resultados</td></tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>