<?php
class Conexion {
    public static function conectar() {
        $l_link = new PDO("mysql:host=localhost;dbname=reparto", "root", "");
        return $l_link;
    }

    public static function comprobarConexion() {
        try {
            $conexion = self::conectar();
            // Si llegamos aquí, la conexión se estableció correctamente
            echo "Conexión exitosa a la base de datos.";
        } catch (PDOException $e) {
            // Si hay un error durante la conexión, mostramos el mensaje de error
            echo "Error de conexión: " . $e->getMessage();
        }
    }
}
?>
