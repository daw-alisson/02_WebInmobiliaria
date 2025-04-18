
<?php
class Conectar {
    // Para conectarse a la BBDD se tendra que llamar a esta clase y a su metodo conexion y se conecta a la base de datos a traves de la variable $conexionEstablecida
    public static function conexion() {
        $host = "localhost";
        $dbname = "inmobiliaria";
        $username = "root";
        $password = "";

        try {
            $conexionEstablecida = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
            $conexionEstablecida->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);//Para que muestre los errores
            
            return $conexionEstablecida;//Devuelve la conexión

        } catch (PDOException $e) {
            die("Error" . $e->getMessage());
            echo "Linea del error" . $e->getLine();
        }

    }


    
}
?>
