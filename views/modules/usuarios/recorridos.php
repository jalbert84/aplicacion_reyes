<?php
if (!isset($_SESSION)) { 
    session_start(); 
} 

if(!$_SESSION["validar"]) {  
    echo "<script>"
        . "window.location.replace(\"http://10.224.24.247/reparto/\");"
        . "</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Reyes Magos - Recorridos</title>

    <!-- GLOBAL STYLES -->
    <link href="/views/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link href="/views/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- THEME STYLES -->
    <link href="/views/css/style.css" rel="stylesheet">
    <link href="/views/css/plugins.css" rel="stylesheet">
    <!-- THEME DEMO STYLES -->
    <link href="/views/css/demo.css" rel="stylesheet">

    <style>
        body {
            background-color: #fff; /* Fondo blanco */
        }

        .large-image {
            margin-top: 50px; /* Espacio entre los botones y la imagen */
            max-width: 100%; /* Ancho máximo de la imagen */
            height: auto; /* Altura automática para mantener la proporción de aspecto */
        }
    </style>
</head>
<body>

    <div class="container">
        <a href="../../dashboard.php" class="btn btn-lg btn-primary">Volver al menú</a>
        <div class="row">
            <div class="col-md-12">
                <h1 class="text-center">Recorridos</h1>
                <div class="text-center">
                    <!-- Botones de recorridos -->
                    <a href="../mapas/mapa-azul.php" class="btn btn-lg btn-primary">Mapa Azul</a>
                    <a href="../mapas/mapa-rojo.php" class="btn btn-lg btn-danger">Mapa Rojo</a>
                    <a href="../mapas/mapa-verde.php" class="btn btn-lg btn-success">Mapa Verde</a>
                    <a href="../mapas/mapa-amarillo.php" class="btn btn-lg btn-warning">Mapa Amarillo</a>
                    <a href="../mapas/mapa-gris.php" class="btn btn-lg btn-default">Mapa Gris</a>
                    <a href="../mapas/mapa-morado.php" class="btn btn-lg btn-purple">Mapa Morado</a>
                </div>
            </div>
        </div>
        <!-- Imagen grande -->
        <div class="row">
            <div class="col-md-12">
                <img src="mapa-prueba.jpg" class="img-responsive center-block large-image" alt="Imagen Grande">
            </div>
        </div>
    </div>

    <!-- GLOBAL SCRIPTS -->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script src="/views/js/plugins/bootstrap/bootstrap.min.js"></script>
    <script src="/views/js/plugins/slimscroll/jquery.slimscroll.min.js"></script>
    <!-- HISRC Retina Images -->
    <script src="/views/js/plugins/hisrc/hisrc.js"></script>
    <!-- THEME SCRIPTS -->
    <script src="/views/js/flex.js"></script>
</body>
</html>
