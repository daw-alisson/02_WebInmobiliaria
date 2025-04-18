<?php   
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ALTA USUARIOS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../css/estilo_viviendas.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">

<!--  ---------------------- CABECERA ---------------------- -->
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
                    <i   class="bi bi-box-arrow-right"></i> Cerrar sesión
                </button>
            </form>
        </div>
    </div>
</header>


<!--  ---------------------- FORMULARIO CON ESTILO MODERNO ---------------------- -->


<div class="container d-flex justify-content-center align-items-center mt-5 mb-5">
    <div class="col-md-6"> <!-- Más ancho para mejor visibilidad -->
        <div class="card shadow-lg border-0 rounded-4">
            <div class="card-header bg-primary text-white text-center rounded-top">
                <h4 class="mb-0">Registro de Usuario</h4>
            </div>
            <div class="card-body p-4">
                <form action="../../controlador/Usuarios_controlador.php?accion=alta" method="POST">
                    
                    <!-- ID Usuario con icono -->
                    <div class="mb-3">
                        <label for="id_usuario" class="form-label">ID Usuario:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-person"></i></span>
                            <input type="text" class="form-control" name="nuevo_id" id="id_usuario" required>
                        </div>
                    </div>

                    <!-- Contraseña generada automáticamente con icono -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" name="nuevo_pass" id="password" 
                            placeholder="Generada automáticamente" readonly>
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="text-center mt-3">
                        <a href="../../controlador/Usuarios_controlador.php?accion=listar" class="btn btn-secondary btn-sm px-4">Cancelar</a>
                        <button type="submit" name="alta" class="btn btn-primary btn-sm px-3">Registrar</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<!-- _____________________________________________________ Modal de Error ________________________________________________________- -->
<div class="modal fade" id="errorModal" tabindex="-1" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-dark">
                <h5 class="modal-title" id="errorModalLabel">Error al dar de alta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body text-center">
                <p>Ese ID ya existe, no se puede crear un usuario que ya existe.</p>
                <p>Por favor, introduzca uno nuevo registro.</p>
            </div>
            <div class="modal-footer d-flex justify-content-center">
                <button type="button" class="btn btn-danger px-5 py-1" data-bs-dismiss="modal">
                    OK
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ------------------------------------ Mostrar el modal de error si hay un error en la URL ------------------------------------------- -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('error')) {
            var errorModal = new bootstrap.Modal(document.getElementById('errorModal'));
            errorModal.show();
        }
    });
</script>

<!-- _____________________________________________ fin de mostar el error ___________________________________________________________________- -->

<!-- ---------------------- PIE DE PÁGINA ---------------------- -->
<footer class="text-white text-center py-4 mt-auto header-bg">
    <p class="mb-0">&copy; Alisson Espin | Todos los derechos reservados</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
