<?php   
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MODIFICAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../vista/css/estilo_viviendas.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

<!--  ---------------------- CABECERA ---------------------- -->
<header class="py-3 header-bg">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center text-center text-md-start">
            <img src="../vista/img/logo_sinFondo.png" class="me-3 rounded-5" style="height: 160px;">
            <h1 class="mb-0 fw-bold">Inmobiliaria</h1>
        </div>

        <!-- Usuario logueado y última conexión -->
        <div class="d-flex flex-column align-items-end ms-auto">
            <h6 class="mb-1 fst-italic">Sesión iniciada por: 
                <strong><?php echo htmlspecialchars($_SESSION['usuario']); ?></strong>
            </h6>
            <h6 class="mb-3 fst-italic">Último acceso: 
                <strong><?php echo htmlspecialchars($_SESSION['ultima_conexion']); ?></strong>
            </h6>
            <!-- Botón de cerrar sesión -->
            <form method="POST" action="../controlador/Usuarios_controlador.php?accion=logout">
                <button type="submit" class="btn btn-danger px-3 py-2">
                    <i  class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</header>

<!-- FORMULARIO -->
<div class="container col-md-6 mx-auto mt-5 mb-5">
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h3 class="text-center">Formulario de modificar Vivienda</h3>
        </div>
        <div class="card-body">
            <form action="../controlador/Viviendas_controlador.php?accion=modificar" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id" value="<?= htmlspecialchars($datos['id']) ?>">
                
                <!-- Tipo de vivienda -->
                <div class="mb-3">
                    <label for="tipo" class="form-label">Tipo de vivienda:</label>
                    <select class="form-select" name="tipo" id="tipo" required>
                        <option value="Piso" <?= ($datos['tipo'] == 'Piso') ? 'selected' : '' ?>>Piso</option>
                        <option value="Casa" <?= ($datos['tipo'] == 'Casa') ? 'selected' : '' ?>>Casa</option>
                        <option value="Adosado" <?= ($datos['tipo'] == 'Adosado') ? 'selected' : '' ?>>Adosado</option>
                        <option value="Chalet" <?= ($datos['tipo'] == 'Chalet') ? 'selected' : '' ?>>Chalet</option>
                    </select>
                </div>
                
                <!-- Zona -->
                <div class="mb-3">
                    <label for="zona" class="form-label">Zona:</label>
                    <select class="form-select" name="zona" id="zona" required>
                        <option value="Centro" <?= ($datos['zona'] == 'Centro') ? 'selected' : '' ?>>Centro</option>
                        <option value="Norte" <?= ($datos['zona'] == 'Norte') ? 'selected' : '' ?>>Norte</option>
                        <option value="Sur" <?= ($datos['zona'] == 'Sur') ? 'selected' : '' ?>>Sur</option>
                        <option value="Este" <?= ($datos['zona'] == 'Este') ? 'selected' : '' ?>>Este</option>
                        <option value="Oeste" <?= ($datos['zona'] == 'Oeste') ? 'selected' : '' ?>>Oeste</option>
                    </select>
                </div>
                
                <!-- Número de dormitorios -->
                <div class="mb-3">
                    <label class="form-label">Número de dormitorios:</label>
                    <div class="d-flex gap-3">
                        <?php
                        $dormitorios = [1, 2, 3, 4, "5+"];
                        foreach ($dormitorios as $dorm) {
                            $checked = ($datos['ndormitorios'] == $dorm) ? 'checked' : '';
                            echo "
                            <div class='form-check'>
                                <input class='form-check-input' type='radio' name='ndormitorios' value='$dorm' id='dorm$dorm' $checked>
                                <label class='form-check-label' for='dorm$dorm'>$dorm</label>
                            </div>";
                        }
                        ?>
                    </div>
                </div>
                
                <!-- Tamaño -->
                <div class="mb-3">
                    <label for="tamano" class="form-label">Tamaño (m²):</label>
                    <input type="number" class="form-control" name="tamano" value="<?= htmlspecialchars($datos['tamano']) ?>" required>
                </div>
                
                <!-- Precio -->
                <div class="mb-3">
                    <label for="precio" class="form-label">Precio (€):</label>
                    <input type="number" class="form-control" name="precio" value="<?= htmlspecialchars($datos['precio']) ?>" required>
                </div>
                
                <!-- Botones -->
                <div class="text-center">
                    <a href="Viviendas_controlador.php" class="btn btn-secondary btn-lg">Cancelar</a>
                    <button type="submit" name="modificar" class="btn btn-primary btn-lg">Modificar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ---------------------- PIE DE PÁGINA ---------------------- -->
<footer class="text-white text-center py-4 mt-auto header-bg">
    <p class="mb-0">&copy; Alisson Espin | Todos los derechos reservados</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
