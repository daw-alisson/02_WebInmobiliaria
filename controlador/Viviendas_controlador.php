<?php
    require_once '../modelo/Viviendas_modelo.php';
    class Viviendas_controlador {

        private $modelo;

        public function __construct() {
            $this->modelo = new Viviendas_modelo();
            
        }
        /* solo listar:
        public function listar() {
            $array = $this->modelo->listar_BBDD();
            require_once '../vista/Viviendas_vista.php';
             
        }*/


        public function listar() {
            // Tamaño de página
            $tamano_pagina = 3;
        
            // Página actual (por defecto es 1)
            $pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
        
            // Obtener total de registros
            $total_registros = $this->modelo->contar_BBDD();
        
            // Asegurar que $total_paginas esté siempre definida
            $total_paginas = ($total_registros > 0) ? ceil($total_registros / $tamano_pagina) : 1;
        
            // Calcular el offset para la consulta
            $empezar_desde = ($pagina_actual - 1) * $tamano_pagina;
        
            // Obtener viviendas para la página actual
            $array = $this->modelo->listar_BBDD($empezar_desde, $tamano_pagina);
        
            // Incluir la vista, pasando los datos
            require_once "../vista/Viviendas_vista.php";
        }
        
        

        //Función para obtener las fotos
        public function fotos($id_vivienda) {
            return $this->modelo->fotos_BBDD($id_vivienda);
        }
    


        public function eliminar() {
            if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
                $id = $_GET['id'];
        
                // Llamar al modelo para eliminar 
                $this->modelo->eliminar_BBDD($id);
        
                // Redirigir a la lista principal
                header("Location: Viviendas_controlador.php?accion=listar");
                exit();
            } 
        }




        // Recoge el id de  la tabla y lo pasa al modelo para que busque los datos de ese id
        public function mostrar_datos() {
            if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
                $id = $_GET['id'];
        
                // Obtener los datos de la vivienda a modificar
                $datos = $this->modelo->id_registro_BBDD($id);
        
                // Incluir la vista con los datos
                header("../vista/formularios/form_modificar_vivienda.php");    
                require_once '../vista/formularios/form_modificar_vivienda.php';
                }
        }
        
        // Recoge los datos del formulario y los pasa al modelo para que los actualice
        public function modificar() {
            if ( isset($_POST['modificar'])) {
                $id = $_POST['id'];
                $tipo = $_POST['tipo'];
                $zona = $_POST['zona'];
                $ndormitorios = $_POST['ndormitorios'];
                $tamano = $_POST['tamano'];
                $precio = $_POST['precio'];
        
                // Crear array con los datos
                $datos = array($id, $tipo, $zona, $ndormitorios, $tamano, $precio);
        
                // Enviar datos al modelo para actualizar
                $this->modelo->modificar_BBDD($datos);
        
                // Redirigir a la lista de viviendas
                header("Location: Viviendas_controlador.php?accion=listar");
                exit();
            } else {
                echo "<script>alert('Error al actualizar la vivienda.');</script>";
                header("refresh:0.8;url=Viviendas_controlador.php?accion=listar");
            }
        }
        
        

        public function alta() {
            if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['alta'])) {
                // Recojo los valores del formulario en variables y luego se los paso al modelo
                $datos = [
                    'tipo' => $_POST['tipo'] ?? '',
                    'zona' => $_POST['zona'] ?? '',
                    'direccion' => $_POST['direccion'] ?? '',
                    'ndormitorios' => $_POST['ndormitorios'] ?? '',
                    'precio' => $_POST['precio'] ?? '',
                    'tamano' => $_POST['tamano'] ?? '',
                    'extras' => isset($_POST['extras']) ? implode(", ", $_POST['extras']) : '',
                    'observaciones' => $_POST['observaciones'] ?? ''
                ];

                if($this->modelo->alta_BBDD($datos)){
                    header('Location: Viviendas_controlador.php?accion=listar'); 
                    exit(); 
                }else{
                    echo "<script>alert('Error al insertar la vivienda.');</script>";
                    header("refresh:0.8;url=Viviendas_controlador.php?accion=alta");
                }
                 
            }
        }


        public function buscar() {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['buscar'])) {
        $tipo = $_POST['tipo'];
        $zona = $_POST['zona'];
        $ndormitorios = $_POST['ndormitorios'];
        $precio = $_POST['precio'];

        $datos = array($tipo, $zona, $ndormitorios, $precio);

        $array = $this->modelo->buscar_BBDD($datos);

        // Si la búsqueda está activa muestra en la vista un titulo que identifque que son los resultados de una búsqueda.
        $busqueda_activa = true; 

        // Si hay resultados, incluir la vista con la variable $busqueda_activa
        if (!empty($array)) {   
            require_once '../vista/Viviendas_vista.php';
        } else {
            /* Si no hay pop up .Si no hay resultados, mostrar un mensaje y redirigir
            echo "<script>alert('No se encontraron resultados con esa búsqueda');</script>";
            header('refresh:0.8;url=Viviendas_controlador.php?accion=listar'); 
            exit()*/

             // Si no hay resultados, redirigir a form_buscar.php con el error
             header("Location: ../vista/formularios/form_buscar.php?error=1");
             exit();
            ;
        }
    }
}

    }

/* ----------------------------------  EJECUTAR ACCIONES SEGÚN LA URL  ---------------------------------- */

    $controlador = new Viviendas_controlador();
    $accion = $_GET['accion'] ?? 'listar';

switch ($accion) {
    case 'listar':
        $controlador->listar();
        break;
    case 'eliminar':
        $controlador->eliminar();
        break;
    case 'alta':
        $controlador->alta();
        break;
    case 'buscar':
        $controlador->buscar();
        break;
    case 'mostrar_datos':
        $controlador->mostrar_datos();
        break;
    case 'modificar':
        $controlador->modificar();
        break;
    default:
        echo "Acción no permitida";
        break;
}


?>
