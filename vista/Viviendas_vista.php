<?php  
session_start();


// Verifica si las variables de sesión están definidas antes de usarlas
$usuario = isset($_SESSION['usuario']) ? $_SESSION['usuario'] : 'Invitado';
$ultima_conexion = isset($_SESSION['ultima_conexion']) ? $_SESSION['ultima_conexion'] : 'No disponible';



require_once '../controlador/Viviendas_controlador.php';
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio</title>
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

        <!-- Sección de usuario logueado  y fecha de la ultima conexion -->
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
<!--  ------------------------------------------------------ fin de cabecera ---------------------------------------------------------->

<!--  ------------------------------------------------ BARRA DE NAVEGACIÓN ---------------------------------------------------------->

 <?php if ($_SESSION['usuario'] == 'admin'): ?> <!-- Que este navegadr solo se pueda ver si el usuario es administrador = admin -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark ">
    <div class="container">
        <a class="navbar-brand" href="#"></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link btn btn btn-warning me-3 text-white me-2" href="../controlador/Usuarios_controlador.php?accion=listar">
                        <i class="bi  bi-person-plus"></i> Gestionar usuarios
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link btn btn-success text-white me-2" href="../vista/formularios/form_alta_vivienda.php">
                        <i class="bi bi-house-add"></i> Alta nueva vivienda
                    </a>
                </li>
              
                <li class="nav-item">
                    <a class="nav-link btn btn-info text-white" href="../vista/formularios/form_buscar.php">
                        <i class="bi bi-search"></i> Buscar vivienda
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!--  ------------------------------------------------ fin de nav ---------------------------------------------------------- -->
<!--  ------------------------------------------------ MENSAJE DE BIENVENIDA ----------------------------------------------- -->
<div class="alert alert-warning alert-dismissible fade show text-center mb-0" role="alert">
        <strong>¡Bienvenido administrador!</strong> Puedes gestionar los usuarios y las viviendas.
    </div>
    
<?php endif; ?> <!--  fin de condicion de vista de admin_________________________________________________________________________ -->
<section class="container mt-5">

    <!-- Icono de casa personalizado -->
    <div class="d-flex flex-column align-items-center mb-3">
        <svg width="80" height="80" viewBox="0 0 24 24" fill="none" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home">
            <path d="M3 9L12 2L21 9V21H14V14H10V21H3V9Z"></path>
        </svg>
    </div>

    <!-- Título si es listado general o listado de busqueda -->
    <h3 class="fw-bold text-center mb-4">
    <?= isset($busqueda_activa) ? "Resultados de la búsqueda" : "Información de viviendas"; ?>
    </h3>


    <!-- --------fin------------------>

    <div class="table-responsive">
        <table class="table table-bordered table-striped custom-table">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Tipo</th>
                    <th>Zona</th>
                    <th>Nº Dormitorios</th>
                    <th>Precio (€)</th>
                    <th>Tamaño (m²)</th>
                    <th>Fotos</th>
                    <?php if ($_SESSION['usuario'] == 'admin'): ?>

                    <th>Acciones</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($array as $registro): ?>
            <tr>
                <td><?= $registro['id'] ?></td>
                <td><?= $registro['tipo'] ?></td>
                <td><?= $registro['zona'] ?></td>
                <td><?= $registro['ndormitorios'] ?></td>
                <td><?= $registro['precio'] ?></td>
                <td><?= $registro['tamano'] ?></td>

                <!--  Se recorren las fotos de cada vivienda y se muestran en la tabla -->
                <td>
                    <?php 
                         $controlador = new Viviendas_controlador();

                        $fotos = $controlador->fotos($registro['id']);
                        if (count($fotos) > 0) {
                            foreach ($fotos as $foto) {
                                $ruta_foto = '../vista/img/' . htmlspecialchars($foto['foto']);
                                echo "<a href='$ruta_foto' target='_blank'>
                                        <img src='$ruta_foto' width='100' height='75' style='margin-right: 10px;'>
                                    </a>";
                            }
                        } else {
                            echo "No hay fotos disponibles";
                        }
                    ?>

                </td>

<!-- ----------------------------------------------- BOTONES DE ACCIONES -------------------------------------------------------  -->
                
                <?php if ($_SESSION['usuario'] == 'admin'): ?> <!-- Solo se pueda ver si el usuario es administrador = admin -->
                <td>

                    <!-- Botones de modificar y eliminar, cuando se pulsa se envía el ID del registro a través de la URL por GET al controlador
                     y se ejecuta la acción correspondiente llamando al método elimina/modifica del controlador,esta a su vez llama al método de eliminar/modificar del modelo -->
                    <a href="../controlador/Viviendas_controlador.php?accion=mostrar_datos&id=<?= $registro['id'] ?>" 
                        class="btn btn-warning" >Modificar 
                    </a>

                    
                    <a href="../controlador/Viviendas_controlador.php?accion=eliminar&id=<?= $registro['id'] ?>" 
                        class="btn btn-danger" > Eliminar
                    </a>

                </td>
                <?php endif; ?>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
<!-- ---------------------------------------------- PAGINACIÓN -----------------------------------------------------------------  -->
         <!--  Recorro el total de páginas, empezando por la página 1 y i será el número de página actual,
           se le añade la clase active que le da el color azul y pagina es el número de página que se le pasa por la URL  -->
<?php if (isset($total_paginas) && $total_paginas > 1) : ?>
<div class="paginacion">
    <ul class="pagination justify-content-center">
        <?php for ($i = 1; $i <= $total_paginas; $i++) : ?>
            <li class="page-item <?= ($i == $pagina_actual) ? 'active' : '' ?>">
                <a class="page-link" href="?pagina=<?= $i ?>"><?= $i ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</div>
<?php endif; ?>


<!-- ------------------------------------------- Fin de paginación --------------------------------------------------------------  -->

    </div>
</section>

<footer class="text-white text-center py-4 mt-auto header-bg">
    <p class="mb-0">&copy; Alisson Espin | Todos los derechos reservados</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
