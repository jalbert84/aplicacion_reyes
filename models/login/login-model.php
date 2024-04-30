<?php

require_once("models/db/conexion.php");

class LoginModel {
    
    #INGRESO USUARIO
    #-------------------------------------

    public static function ingresoUsuarioModel($datosModel, $tabla) {

        $stmt = Conexion::conectar()->prepare("SELECT EMAIL, PASSWORD FROM $tabla WHERE EMAIL = :EMAIL");
        $stmt->bindParam(":EMAIL", $datosModel["email"], PDO::PARAM_STR);
        $stmt->execute();

        #fetch(): Obtiene una fila de un conjunto de resultados asociado al objeto PDOStatement. 
        return $stmt->fetch();

        $stmt->closeCursor();
    }

}
