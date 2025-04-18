<?php   
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALTA VIVIENDAS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/estilo_viviendas.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

<!--  ------------------------------------------------ CABECERA --------------------------------- -->
<header class="py-3 header-bg">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center text-center text-md-start">
            <img src="../img/logo_sinFondo.png" class="me-3 rounded-5" style="height: 160px;">
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
            <form method="POST" action="../../controlador/Usuarios_controlador.php?accion=logout">
                <button type="submit" class="btn btn-danger px-3 py-2">
                    <i  class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</header>

<!--  ----------------------------------------------- FORMULARIO  --------------------------------------- -->
<div class="container d-flex justify-content-center align-items-center mt-5 mb-5">
    <div class="col-md-5"> <!-- Hacemos el formulario más pequeño (antes era col-md-6) -->
        <div class="card shadow-lg border-0">
            <div class="card-header bg-primary text-white text-center">
                <h5 class="mb-0">Formulario de alta Vivienda</h5>
            </div>
            <div class="card-body p-3"> <!-- Reducimos el padding interno -->
                <form action="../../controlador/Viviendas_controlador.php?accion=alta" method="POST" enctype="multipart/form-data">
                    
                    <div class="row g-2"> <!-- Espacio reducido entre filas -->
                        <!-- Tipo de Vivienda -->
                        <div class="col-md-6">
                            <label for="tipo" class="form-label">Tipo:</label>
                            <select class="form-select form-select-sm" name="tipo" id="tipo" required>
                                <option value="Piso">Piso</option>
                                <option value="Casa">Casa</option>
                                <option value="Adosado">Adosado</option>
                                <option value="Chalet">Chalet</option>
                            </select>
                        </div>

                        <!-- Precio -->
                        <div class="col-md-6">
                            <label for="precio" class="form-label">Precio (€):</label>
                            <input type="number" class="form-control form-control-sm" name="precio" id="precio" placeholder="12.000" required>
                        </div>

                        <!-- Zona -->
                        <div class="col-md-6">
                            <label for="zona" class="form-label">Zona:</label>
                            <select class="form-select form-select-sm" name="zona" id="zona" required>
                                <option value="Centro">Centro</option>
                                <option value="Norte">Norte</option>
                                <option value="Sur">Sur</option>
                                <option value="Este">Este</option>
                                <option value="Oeste">Oeste</option>
                            </select>
                        </div>

                        <!-- Tamaño -->
                        <div class="col-md-6">
                            <label for="tamano" class="form-label">Tamaño (m²):</label>
                            <input type="number" class="form-control form-control-sm" name="tamano" id="tamano" required>
                        </div>

                        <!-- Dirección -->
                        <div class="col-md-12">
                            <label for="direccion" class="form-label">Dirección:</label>
                            <input type="text" class="form-control form-control-sm" name="direccion" id="direccion" required>
                        </div>

                        <!-- Dormitorios -->
                        <div class="col-md-12">
                            <label class="form-label">Dormitorios:</label>
                            <div class="d-flex gap-2">
                                <input class="form-check-input" type="radio" name="ndormitorios" value="1"> 1
                                <input class="form-check-input" type="radio" name="ndormitorios" value="2"> 2
                                <input class="form-check-input" type="radio" name="ndormitorios" value="3" checked> 3
                                <input class="form-check-input" type="radio" name="ndormitorios" value="4"> 4
                                <input class="form-check-input" type="radio" name="ndormitorios" value="5+"> 5+
                            </div>
                        </div>

                        <!-- Extras -->
                        <div class="col-md-12">
                            <label class="form-label">Extras:</label>
                            <div class="d-flex gap-2">
                                <input class="form-check-input" type="checkbox" name="extras[]" value="Piscina"> Piscina
                                <input class="form-check-input" type="checkbox" name="extras[]" value="Jardín"> Jardín
                                <input class="form-check-input" type="checkbox" name="extras[]" value="Garaje"> Garaje
                            </div>
                        </div>

                        <!-- Foto -->
                        <div class="col-md-12">
                            <label for="foto" class="form-label">Foto:</label>
                            <input type="file" class="form-control form-control-sm" name="foto" id="foto" accept="image/*">
                        </div>

                        <!-- Observaciones -->
                        <div class="col-md-12">
                            <label for="observaciones" class="form-label">Observaciones:</label>
                            <textarea class="form-control form-control-sm" name="observaciones" id="observaciones" rows="2"></textarea>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="text-center mt-3">
                        <a href="../../controlador/Viviendas_controlador.php" class="btn btn-secondary btn-sm px-3">Cancelar</a>
                        <button type="submit" name="alta" class="btn btn-primary btn-sm px-3">Dar de alta</button>
                    </div>

                </form>
            </div>
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
