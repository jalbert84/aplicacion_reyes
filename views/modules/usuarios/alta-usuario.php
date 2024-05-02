<?php
// Lista de calles de Alfara del Patriarca
$calles = [
    "8 DE MARZO",
    "ANTONIO ESPOLIO",
    "ASSEGADORS",
    "AUSIAS MARCH",
    "BLASCO IBANYEZ",
    "BONIFACI FERRER",
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
    "PLAZA ANTIC REGNE DE VALENCIA",
    "PLAZA LA CREU",
    "PLAZA NOU D’OCTUBRE",
    "PLAZA SANT JOAN DE RIBERA",
    "POETA RICARDO VALERO",
    "PRIMER DE MAIG (1-8)",
    "PRIMER DE MAIG (19-FINAL)",
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
    "VICENT LASSALA"
];

// Iniciar sesión si no está iniciada
if (!isset($_SESSION)) { 
    session_start(); 
} 

// Verificar si el usuario está autenticado
if(!$_SESSION["validar"]) {  
    echo "<script>"
        . "window.location.replace(\"http://10.224.24.247/reparto/\");"
        . "</script>";
    exit();
}

// Verificar si se ha enviado el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Verificar si los campos requeridos están presentes en $_POST
    if(isset($_POST["nombreRegistro"]) && isset($_POST["calleRegistro"]) && isset($_POST["numeroRegistro"]) && isset($_POST["regalosRegistro"])) {
        // Capturar los datos del formulario
        $datos = array(
            "nombre" => $_POST["nombreRegistro"],
            "calle" => $_POST["calleRegistro"],
            "numero" => $_POST["numeroRegistro"],
            "regalos" => $_POST["regalosRegistro"]
            // Agrega aquí más campos si los necesitas
        );

        // Incluir el controlador de usuarios
        require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");

        // Crear una instancia del controlador de usuarios
        $registro = new UsuariosController();

        // Llamar al método para registrar usuario y pasar los datos
        $registro->registroUsuarioController($datos);

        echo '<script>alert("¡Usuario registrado correctamente!");</script>';
    } else {
        // Si faltan campos, muestra un mensaje de error
        echo '<script>alert("¡Error! Faltan campos obligatorios en el formulario.");</script>';
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
    <title>Alta de Usuario</title>

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
                <h1 class="text-center" style="color: white;">Alta de Usuario</h1>
                        <a href="/views/dashboard.php" class="btn btn-primary">Volver al menú</a>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="col-lg-6">
            <div class="portlet portlet-default">
                <div class="portlet-heading">
                    <div class="portlet-title">
                        <h4>Formulario de registro</h4>
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
                            <label for="inputNombre">Nombre del usuario</label>
                            <input type="text" id="inputNombre" name="nombreRegistro" class="form-control" placeholder="Ingrese el nombre y apellido de usuario" required>
                            </div>

                            <div class="form-group">
                                <label for="inputCalle">Calle</label>
                                <!-- Lista desplegable para seleccionar la calle -->
                                <select name="calleRegistro" class="form-control" required>
                                <option value="">Seleccione una calle</option>
                            <?php foreach ($calles as $calle) { ?>
                            <option value="<?php echo $calle; ?>"><?php echo $calle; ?></option>
                            <?php } ?>
                            </select>
                            </div>


                            <div class="form-group">
                            <label for="inputNumero">Número y puerta</label>
                            <input type="text" id="inputNumero" name="numeroRegistro" class="form-control" placeholder="Ingrese número y puerta" required>

                            </div>
                            
                            <div class="form-group">
                            <label for="inputRegalos">Regalos</label>
                            <input type="text" id="inputRegalos" name="regalosRegistro" class="form-control" placeholder="Ingrese los regalos" required>

                            </div>

                            <button type="submit" class="btn btn-default">Guardar registro</button>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /.portlet -->
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
