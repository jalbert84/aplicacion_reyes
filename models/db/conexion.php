<?php
class Conexion {
    public static function conectar() {
        $l_link = new PDO("mysql:host=localhost;dbname=recogida", "root", "");
        return $l_link;
    }

    public static function comprobarConexion() {
        try {
            $conexion = self::conectar();
            // Si llegamos aquí, la conexión se estableció correctamente
            echo "Conexió exitosa a la base de dades.";
        } catch (PDOException $e) {
            // Si hay un error durante la conexión, mostramos el mensaje de error
            echo "Error de conexió: " . $e->getMessage();
        }
    }
}
?>
