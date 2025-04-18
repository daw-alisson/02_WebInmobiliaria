<?php 
 session_start(); // Asegurar que la sesión está iniciada antes de cualquier operación
require_once "../modelo/Usuarios_modelo.php";

class Usuarios_controlador {
    
    private $modelo;

    public function __construct() {
        $this->modelo = new Usuarios_modelo();
    }


    public function login() {  
        session_start(); // Asegura que la sesión esté iniciada
    
        if(isset($_POST['login'])) {

                
                    $usuario = $_POST['username'];
                    $password = $_POST['password'];
            
                    // Comprobar si el usuario existe en la BBDD
                    $hash = $this->modelo->comprueba_usuario_BBDD($usuario);
                    
                    // Comprobar si la contraseña es correcta
                    if ($hash && password_verify($password, $hash)) { 
                            // Iniciar sesión antes de asignar valores
                            $_SESSION['usuario'] = $usuario;
                            // Crear una cookie con la última conexión
                            $cookie_nombre = "ultima_conexion_" . $usuario;
                            // Comprobar si la cookie existe
                            if (isset($_COOKIE[$cookie_nombre])) {
                                // Asignar la última conexión a la sesión
                                $_SESSION['ultima_conexion'] = $_COOKIE[$cookie_nombre];
                            } else {
                                // Si no existe la cookie, asignar un valor por defecto
                                $_SESSION['ultima_conexion'] = "Primera vez";
                            }
                            
                            // variable de sesión para controlar el tiempo de inactividad
                            $fecha_actual = date("d-m-Y H:i:s");
                            // Asignar la fecha actual a la sesión
                            setcookie($cookie_nombre, $fecha_actual, time() + 604800, '/'); // 1 semana
                
                            header("Location: ./Viviendas_controlador.php");
                            exit();
                    } else {
                        header("Location: ../index.php?error=1"); // Redirigir con un parámetro de error
                        exit();
                    }

            
        } // Fin del if isset
    }
    


    public function logout() {
        session_start();
        session_unset(); // Eliminar todas las variables de sesión
        session_destroy(); // Destruir la sesión
    
        // Redirigir al login después de cerrar sesión
        header("Location: ../index.php");
        exit();
    }


    public function listar() {
        $array = $this->modelo->listar_BBDD();
        require_once '../vista/Usuarios_vista.php';
         
    }


    public function eliminar() {
        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['id'])) {
            $id = $_GET['id'];
    
            // Comprobar que no se elimine el usuario admin si se intenta eliminar el usuario admin se muestra un mensaje de alerta
            // solo en el caso de que no se controle en el formulario de la vista.
            if($id === 'admin') {
                echo "<script>alert('No se puede eliminar el usuario Admin');</script>";
                header("refresh:0.8;url=Usuarios_controlador.php?accion=listar");
                exit();
            }else{
                $this->modelo->eliminar_BBDD($id);
                header("Location: Usuarios_controlador.php?accion=listar");
                exit();
            }
        } else {
            echo "<script>alert('No se recibio ningún ID');</script>";
        }
    }
    


    
    public function alta() {

        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['alta'])) {
            $id_usuario = $_POST["nuevo_id"];

            // Generar una contraseña aleatoria de 4 dígitos de manera alearoria
            $password = rand(1000, 9999);

             // Comprobar si el usuario ya existe
            $existe = $this->modelo->comprueba_usuario_BBDD($id_usuario);
            if ($existe) {
                /* // si no ubiese el pop up de error
                echo "<script>alert('El usuario ya existe');</script>"; 
                header("refresh:0.8;url=Usuarios_controlador.php?accion=listar");*/

                header("Location: ../vista/formularios/form_alta_usuario.php?error=1");
                exit();
                
            } else {
                $this->modelo->alta_BBDD($id_usuario, $password);
                header("Location: Usuarios_controlador.php?accion=listar");
                exit();
            }
        }
    }



}
/* ---------------------------------- Ejecuta acciones según la URL --------------------------------------- */

// Cuando carga la página por primera vez, no hay ninguna acción y por defecto se muestra el login.
// Una ves que entra se ejecuta listado.
// Si se pulsa el botón de eliminar se ejecuta la acción eliminar.
// Si se pulsa el botón de alta se ejecuta la acción alta.
// Si se pulsa el botón de logout se ejecuta la acción logout.


$controlador = new Usuarios_controlador();
$accion = $_GET['accion'] ?? 'login';

switch ($accion) {
    case 'login':
        $controlador->login();
        break;
    case 'logout':
        $controlador->logout();
        break;
    case 'listar':
        $controlador->listar();
        break; 
    case 'eliminar':
        $controlador->eliminar();
        break; 
    case 'alta':
        $controlador->alta();
        break;
    default:
        echo "Acción no permitida";
        break;
}

?>
