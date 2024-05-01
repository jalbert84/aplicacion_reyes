<script>
    // Función para mostrar mensaje de alerta
    function showAlert(message) {
        alert(message);
    }

    // Función para mostrar mensaje de alerta y redirigir
    function showAlertAndRedirect(message, url) {
        alert(message);
        window.location.href = url;
    }
</script>




<?php
// Lista de calles de Alfara del Patriarca
$calles = [
    "ANTONIO_ESPOLIO",
    "ASSEGADORS",
    "AUSIAS_MARCH",
    "BONIFACI_FERRER",
    "BLASCO_IBANYEZ",
    "CALVARI",
    "CAMI DE RAFELBUNYOL",
    "CAVALLERS (10-FINAL)",
    "CAVALLERS-LA PAU- (1-9)",
    "DOCTOR NAVARRO",
    "DON EMILIO RAMON LLIN",
    "LA NORIA",
    "LA SEQUIA",
    "MAJOR",
    "MESTRE PALAU",
    "MESTRE SERRANO",
    "PLAZA ANTIC REGNE DE VALÈNCIA",
    "PLAZA LA CREU",
    "PLAZA NOU D’OCTUBRE",
    "PLAZA SANT JOAN DE RIBERA",
    "POETA RICARDO VALERO",
    "PRIMER DE MAIG",
    "8 DE MARZO",
    "PUNTARRO",
    "RAJOLARS",
    "REAL ACEQUIA DE MONCADA",
    "RAMON I CAJAL",
    "SANT BERTOMEU",
    "SANT DIDAC",
    "SANT VICENT",
    "SANTA BARBERA",
    "TARAZONA",
    "TIRANT LO BLANC",
    "VALENCIA",
    "VICENT_LASSALA"
];

if (!isset($_SESSION)) { 
    session_start(); 
} 

if(!$_SESSION["validar"]) {  
    echo "<script>"
        . "window.location.replace(\"http://10.224.24.247/reparto/\");"
        . "</script>";
    exit();
}


/// Verificar si se envió el formulario de modificación
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Agregar alerta de JavaScript para verificar si se envió el formulario
    echo "<script>showAlert('Se envió el formulario de modificación');</script>";
// Verificar si se recibió el nombre de usuario y los nuevos datos
if (isset($_POST["nombreModificacion"]) && isset($_POST["calleModificacion"]) && isset($_POST["nuevoNombre"]) && isset($_POST["nuevoNumero"]) && isset($_POST["nuevosRegalos"])) {
    // Obtener los datos del formulario
    $usuario = $_POST["nombreModificacion"]; // Cambiar aquí
    $calle = $_POST["calleModificacion"];
    $nuevoNombre = $_POST["nuevoNombre"];
    $nuevoNumero = $_POST["nuevoNumero"];
    $nuevosRegalos = $_POST["nuevosRegalos"];

    // Llamar al método del controlador para modificar los datos del usuario
    require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");
    $controlador = new UsuariosController();
    $resultado = $controlador->modificarUsuarioController($usuario, $calle, $nuevoNombre, $nuevoNumero, $nuevosRegalos);

    // Mostrar mensaje de alerta con el resultado
    echo "<script>showAlert('$resultado');</script>";
} else {
    // Si faltan campos, muestra un mensaje de error
    echo '<script>showAlert("Error! Faltan campos obligatorios en el formulario.");</script>';
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
    <title>Modificar Usuario</title>

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
        <h1 class="text-center" style="color: white;">Modificación de Usuario</h1>
        <a href="/views/dashboard.php" class="btn btn-primary">Volver al menú</a>
        </div>
    </div>
    <!-- /.col-lg-12 -->
</div>

<div class="col-lg-6">
    <div class="portlet portlet-default">
        <div class="portlet-heading">
            <div class="portlet-title">
                <h4>Modificación de usuario</h4>
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
        <label for="inputUsuario">Nombre de Usuario</label>
        <input type="text" name="nombreModificacion" class="form-control" placeholder="Ingrese el nombre de usuario a modificar" required>
    </div>

    <div class="form-group">
                        <label for="inputCalle">Calle</label>

                        <!-- Lista desplegable para seleccionar la calle -->
                        <<select name="calleModificacion" class="form-control" required>
                        <option value="">Seleccione una calle</option>
                        <?php foreach ($calles as $calle) { ?>
                        <option value="<?php echo $calle; ?>"><?php echo $calle; ?></option>
                        <?php } ?>
                        </select>

                    </div>
    <!-- Aquí deberías agregar los campos que permitan modificar los datos del usuario -->
    <div class="form-group">
        <label for="inputNuevoNombre">Nuevo nombre</label>
        <input type="text" name="nuevoNombre" class="form-control" placeholder="Ingrese el nuevo nombre"required>
    </div>

    <div class="form-group">
        <label for="inputNuevoNumero">Nuevo número y/o puerta</label>
        <input type="text" name="nuevoNumero" class="form-control" placeholder="Ingrese el nuevo número y/o puerta"required>
    </div>                            

    <div class="form-group">
        <label for="inputNuevosRegalos">Nuevos Regalos</label>
        <input type="text" name="nuevosRegalos" class="form-control" placeholder="Ingrese los nuevos regalos"required>
    </div>
    <button type="submit" class="btn btn-default">Modificar usuario</button>
</form>

            </div>
        </div>
    </div>
    <!-- /.portlet -->
</div>
</body>
</html>