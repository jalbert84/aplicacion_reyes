<?php 
$login_success = false;
if (!isset($_SESSION)) { session_start(); } 
if(!$_SESSION["validar"]){  
    if (!$login_success) {
        // Si el inicio de sesión falla, redirige de vuelta a la página de inicio con un parámetro de error
        header("Location: ../index.php?login_error=true");
        exit;
    }
    echo "<script>"
    . "window.location.replace(\"http://10.224.24.247/recogida/\");"
    . "</script>";
exit();
}

require_once("../models/db/conexion.php");

// Llama al método para comprobar la conexión
Conexion::comprobarConexion();
// Cierra la sesión
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Reyes Magos - Menú</title>

    <!-- GLOBAL STYLES -->
    <link href="css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link href="icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- PAGE LEVEL PLUGIN STYLES -->
    <!-- THEME STYLES -->
    <link href="css/style.css" rel="stylesheet">
    <link href="css/plugins.css" rel="stylesheet">
    <!-- THEME DEMO STYLES -->
    <link href="css/demo.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1 class="text-center" style="color: white;">Recogida regalos Reyes Magos</h1>
            <div class="text-center">
                <a href="modules/usuarios/alta-usuario.php" class="btn btn-lg btn-primary">Alta de Usuario</a>
                <a href="modules/usuarios/baja-usuario.php" class="btn btn-lg btn-primary">Baja de Usuario</a>
                <!-- <a href="modules/usuarios/modi-usuario.php" class="btn btn-lg btn-primary">Modificar Usuario</a> -->
                <a href="modules/usuarios/listar-usuarios.php" class="btn btn-lg btn-primary">Orden de reparto</a>
                <a href="modules/usuarios/recorridos.php" class="btn btn-lg btn-primary">Recorridos</a>
            </div>
        </div>
    </div>
    <!-- Aquí se agrega el contenedor para la imagen -->
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <img src="../views/icons/Imagen_reyes.jpg" alt="Descripción de la imagen" class="img-fluid" style="margin-top: 20px;">
        </div>
    </div>
</div>

    <!-- GLOBAL SCRIPTS -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="js/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- HISRC Retina Images -->
    <script src="js/plugins/hisrc/hisrc.js"></script>
    <!-- THEME SCRIPTS -->
    <script src="js/flex.js"></script>
</body>

<button type="button" onclick="confirmLogout()"><i class="fa fa-sign-out"></i> Log Out</button>


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script>
    // Función para mostrar el modal de confirmación
    function confirmLogout() {
        if (confirm("¿Ya te vas montón de mierda? Pues un abrazo")) {
            // Si el usuario confirma, redirige a index.php
            window.location.href = "log-out.php";
        } else {
            // Si el usuario cancela, no hace nada
        }
    }
    
    </script>
</html>
