<?php

class LoginController {
    
    #INGRESO DE USUARIOS
    #------------------------------------

    public function ingresoUsuarioController() {

        // Define el usuario y la contraseña
        $usuarioValido = "usuario"; // Cambia esto por el usuario que desees
        $contraseñaValida = "contraseña"; // Cambia esto por la contraseña que desees

        if (isset($_POST["usuarioIngreso"]) && isset($_POST["passwordIngreso"])) {

            $emailIngresado = $_POST["usuarioIngreso"];
            $passwordIngresada = $_POST["passwordIngreso"];

            if ($emailIngresado == $usuarioValido && $passwordIngresada == $contraseñaValida) {
                
                session_start();
                $_SESSION["validar"] = true;                                
                header("location:views/index.php");
                exit();
                
            } else {                
                header("location:index.php?action=fail");
                exit();
            }
        }
    }

}

