
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vista de usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../vista/css/estilo_viviendas.css">
</head>

<body class="d-flex flex-column min-vh-100 bg-light">
<!--  ------------------------------------------------------ CABECERA ------------------------------------------------------------------->
<header class="py-3 header-bg">
    <div class="container d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center text-center text-md-start">
            <img src="../vista/img/logo_sinFondo.png" class="me-3 rounded-5" style="height: 160px;">
            <h1 class="mb-0 fw-bold">Inmobiliaria</h1>
        </div>
        
         <!-- Sección de usuario logueado  y fecha de último acceso -->
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
<!--  ------------------------------------------------------fin de cabecera ------------------------------------------------------------------->

<!--  ------------------------------------------------ BARRA DE NAVEGACIÓN -------------------------------------------------------------------->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <div class="container">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Botón de volver atrás -->
        <a  href="../controlador/Viviendas_controlador.php" class="btn btn-warning me-3">
            <i class="bi bi-arrow-left-circle"></i> Volver al Inicio
        </a>

        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
               
                <li class="nav-item">
                    <a class="nav-link btn btn-success text-white me-2" href="../vista/formularios/form_alta_usuario.php">
                        <i class="bi bi-person-plus"></i> Alta nuevo usuario
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
<!-- --------------------------------------------------------- fin de nav --------------------------------------------------------------------->


<section class="container mt-5">

    <!-- -------- icono de usuario ---------- -->
    <div class="d-flex flex-column align-items-center mb-3">
        <svg width="100" height="100" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
            <circle cx="12" cy="8" r="5"></circle>
            <path d="M4 21c0-4 4-7 8-7s8 3 8 7"></path>
        </svg>
    </div>
    <!-- -------- fin de icono ------------- -->


    <h3 class="fw-bold text-center mb-4">Información de usuarios</h3>

    <div class="table-responsive">
        <table class="table table-bordered table-striped custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Contraseña</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($array as $registro): ?>
            <tr>
                <td><?= $registro['id_usuario'] ?></td>
                <td><?= $registro['password'] ?></td>
                <td>
 <!-- --------------------------------------------------------- BOTÓN DE ELIMINAR ---------------------------------------------------------->
                       
<!-- Boton de eliminar, cuando se pulsa se envía el ID del registro a través de la URL por GET al controlador y se ejecuta la acción llamando 
 al método eliminar del controlador y esta a su vez llama al método de eliminar del modelo -->

                    <!-- Que NO smuestre el botón de borrar par aadmin -->
                    <?php if ($_SESSION['usuario'] !== 'admin' || $_SESSION['usuario'] !== $registro['id_usuario']): ?>

                    <a href="../controlador/Usuarios_controlador.php?accion=eliminar&id=<?= $registro['id_usuario'] ?>" 
                        class="btn btn-danger">Eliminar
                    </a>

                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>

       
    </div>
</section>


<!-- ---------------------------------------------------- Footer ----------------------------------------------------------------- -->

<footer class="text-white text-center py-4 mt-auto header-bg">
    <p class="mb-0">&copy; Alisson Espin | Todos los derechos reservados</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>



</body>
</html>
