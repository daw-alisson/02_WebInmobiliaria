<?php

require_once ('Conectar.php');

class Usuarios_modelo {

    private $db;
    private $array;

    public function __construct() {
        $this->db = Conectar::conexion();
        $this->array = array();

    }

    public function comprueba_usuario_BBDD($usuario) {
        //Comprobamos si el usuario existe en la base de datos
        $sql = "SELECT password FROM usuarios WHERE id_usuario = :usuario";
        $consulta = $this->db->prepare($sql);
        $consulta->execute([':usuario' => $usuario]);
        $resultado = $consulta->fetch(PDO::FETCH_ASSOC);

        return $resultado ? $resultado['password'] : null; //devolvemos la contraseña encriptada
    }


    
    public function listar_BBDD() {
        try {
            $consulta = $this->db->query("SELECT * FROM usuarios "); 
            if ($consulta) {
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $this->array[] = $fila;
                }
            }
            return $this->array; 
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }


    public function eliminar_BBDD($id) {
        try {
            $sql = "DELETE FROM usuarios WHERE id_usuario = :id";
            $consulta = $this->db->prepare($sql);
            return $consulta->execute([':id' => $id]);
        } catch (Exception $e) {
            die("Error eliminando  " . $e->getMessage());
        }
        
    }

  
    public function alta_BBDD($id_usuario, $password) {
        // Encriptar la contraseña antes de guardarla
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
            
        try {
            $sql = "INSERT INTO usuarios (id_usuario, password)
            VALUES (:id_usuario, :password)";
            $consulta = $this->db->prepare($sql);
        
            
            $consulta->execute([
                ':id_usuario' => $id_usuario,
                ':password' => $hashed_password
            ]);

        } catch (Exception $e) {
            die("Error registrando usuario: " . $e->getMessage());
        }
    }

}

?>
