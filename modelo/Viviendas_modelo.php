<?php
    class Viviendas_modelo {
        private $db;
        private $array;

        public function __construct() {
            require_once("Conectar.php");
            $this->db = Conectar::conexion();
            $this->array = array();
        }

       

        /* solo listar:
        public function listar_BBDD() {
            try {
                $consulta = $this->db->query("SELECT * FROM viviendas ORDER BY fecha_anuncio DESC"); //DESC: va desde la más reciente a la más antigua
                if ($consulta) {
                    while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                        $this->array[] = $fila;
                    }
                }
                return $this->array; 
            } catch (Exception $e) {
                die("Error: " . $e->getMessage());
            }
        }*/
        
        public function contar_BBDD() {
            $consulta = $this->db->query("SELECT COUNT(*) as total FROM viviendas");
            return $consulta->fetch(PDO::FETCH_ASSOC)['total'];
        }
        
        //Listar con paginación
        public function listar_BBDD($inicio, $limite) {
            $consulta = $this->db->prepare("SELECT * FROM viviendas ORDER BY fecha_anuncio DESC LIMIT :inicio, :limite");
            $consulta->bindParam(":inicio", $inicio, PDO::PARAM_INT);
            $consulta->bindParam(":limite", $limite, PDO::PARAM_INT);
            $consulta->execute();
            return $consulta->fetchAll(PDO::FETCH_ASSOC);
        }

        public function fotos_BBDD($id_vivienda) {
            $sql = "SELECT foto FROM fotos WHERE id_vivienda = :id_vivienda";
            $query = $this->db->prepare($sql);
            $query->bindValue(':id_vivienda', $id_vivienda, PDO::PARAM_INT);
            $query->execute();
            
            return $query->fetchAll(PDO::FETCH_ASSOC);
        }

        
        

        public function eliminar_BBDD($id) {
            try {
                $sql = "DELETE FROM viviendas WHERE id = :id";
                $consulta = $this->db->prepare($sql);
                return $consulta->execute([':id' => $id]);
            } catch (Exception $e) {
                die("Error eliminando  " . $e->getMessage());
            }
        }

        public function id_registro_BBDD($id) {
            try {
                $sql = "SELECT * FROM viviendas WHERE id = :id";
                $consulta = $this->db->prepare($sql);
                $consulta->execute(['id' => $id]);
        
                $datos= $consulta->fetch(PDO::FETCH_ASSOC);
                return $datos;
        
            } catch (Exception $e) {
                die("Error buscando vivienda: " . $e->getMessage());
            }
        }
        
        public function modificar_BBDD($datos) {
            try {
                $sql = "UPDATE viviendas 
                        SET tipo = :tipo, zona = :zona, ndormitorios = :ndormitorios, tamano = :tamano, precio = :precio 
                        WHERE id = :id";
                $consulta = $this->db->prepare($sql);
                $consulta->execute([
                    'id' => $datos[0],
                    'tipo' => $datos[1],
                    'zona' => $datos[2],
                    'ndormitorios' => $datos[3],
                    'tamano' => $datos[4],
                    'precio' => $datos[5]
                ]);
        
            } catch (Exception $e) {
                die("Error modificando vivienda: " . $e->getMessage());
            }
        }
        

        public function alta_BBDD($datos) {

            try {
               
                $sql = "INSERT INTO viviendas (tipo, zona, direccion, ndormitorios, precio, tamano, extras, observaciones, fecha_anuncio)
                 VALUES (:tipo, :zona, :direccion, :ndormitorios, :precio, :tamano, :extras, :observaciones, NOW())";

                
                $stmt = $this->db->prepare($sql);

                $stmt->bindParam(':tipo', $datos['tipo']);
                $stmt->bindParam(':zona', $datos['zona']);
                $stmt->bindParam(':direccion', $datos['direccion']);
                $stmt->bindParam(':ndormitorios', $datos['ndormitorios']);
                $stmt->bindParam(':precio', $datos['precio']);
                $stmt->bindParam(':tamano', $datos['tamano']);
                $stmt->bindParam(':extras', $datos['extras']);
                $stmt->bindParam(':observaciones', $datos['observaciones']);
            
                return $stmt->execute();
                
            } catch (Exception $e) {
                die("Error insertando " . $e->getMessage());
            }
        }
        

        public function buscar_BBDD($datos) {
            try {
                $sql = "SELECT * FROM viviendas WHERE tipo = :tipo AND zona = :zona AND ndormitorios = :ndormitorios AND precio <= :precio";
                $consulta = $this->db->prepare($sql);
                $consulta->execute([
                    ':tipo' =>  $datos[0] ,
                    ':zona' =>  $datos[1] ,
                    ':ndormitorios' => $datos[2],
                    ':precio' => $datos[3]
                ]);
                while ($fila = $consulta->fetch(PDO::FETCH_ASSOC)) {
                    $this->array[] = $fila;
                }
                return $this->array;
            } catch (Exception $e) {
                die("Error buscando " . $e->getMessage());
            }
        }
        
    }
?>
