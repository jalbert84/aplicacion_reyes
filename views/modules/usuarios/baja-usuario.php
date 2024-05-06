<?php 
if (!isset($_SESSION)) { 
    session_start(); 
} 

if(!$_SESSION["validar"]) {  
    echo "<script>"
        . "window.location.replace(\"http://10.224.24.247/recogida/\");"
        . "</script>";
    exit();
}

require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");

// Obtener todas las calles disponibles para el desplegable
$controlador = new UsuariosController();
$calles = $controlador->obtenerCallesDisponiblesController();

// Verificar si se envió el formulario de baja
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["nombreBaja"]) && isset($_POST["calleBaja"])) {
        $nombre = $_POST["nombreBaja"];
        $calle = $_POST["calleBaja"];

        // Verificar que se proporcionaron valores válidos
        if (!empty($nombre) && !empty($calle)) {
            // Verificar si el usuario existe en la base de datos
            $existeUsuario = $controlador->verificarUsuarioController($nombre, $calle);

            if ($existeUsuario) {
                // Realizar la acción de baja
                $resultado = $controlador->bajaUsuarioController($nombre, $calle);

                // Verificar el resultado de la operación
                if ($resultado === true) {
                    $_SESSION['mensaje'] = "Usuario eliminado correctamente.";
                } else {
                    $_SESSION['mensaje'] = $resultado; // Mensaje de error
                }
            } else {
                $_SESSION['mensaje'] = "ESO QUE HAS ESRITO NO LO TENGO. ";
            }
        } else {
            $_SESSION['mensaje'] = "Por favor, proporcione el nombre y calle del usuario a dar de baja.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Baja de Usuario</title>

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
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="page-title">
                <h1 class="text-center" style="color: white;">Baja de Usuario</h1>
                <a href="/views/dashboard.php" class="btn btn-primary">Volver al menú</a>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4>Formulario de baja de usuario</h4>
                    </div>
                    <div class="portlet-widgets">
                        <a data-toggle="collapse" data-parent="#accordion" href="#basicFormExample"><i class="fa fa-chevron-down"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div id="basicFormExample" class="panel-collapse collapse in">
                    <div class="portlet-body">
                        <form role="form" method="post">
                            <div class="form-group">
                                <label for="inputUsuario">Nombre</label>
                                <input type="text" name="nombreBaja" class="form-control" placeholder="Ingrese el nombre del usuario a dar de baja" required>
                            </div>
                            <div class="form-group">
                                <label for="inputCalle">Calle</label>
                                <select name="calleBaja" class="form-control" required>
                                    <option value="">Seleccione la calle</option>
                                    <?php foreach ($calles as $calle) { ?>
                                        <option value="<?php echo $calle; ?>"><?php echo $calle; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-default">Dar de baja</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Agrega un div para mostrar el mensaje -->
        <div id="mensaje" style="display: none;"></div>
        <?php
        // Mostrar mensaje de confirmación o error si se ha eliminado o no el usuario
        if (isset($_SESSION['mensaje'])) {
            echo "<div id='mensaje-exito' class='alert alert-success'>" . $_SESSION['mensaje'] . "</div>";
            unset($_SESSION['mensaje']);
        }
        ?>
        <script>
            // Ocultar el mensaje después de 3 segundos
            setTimeout(function(){
                var mensajeDiv = document.getElementById('mensaje-exito');
                if (mensajeDiv) {
                    mensajeDiv.style.display = 'none';
                }
            }, 3000);
        </script>
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
