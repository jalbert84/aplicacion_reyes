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

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Listado de Calles</title>

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
                <h1 class="text-center">Listado de calles</h1>
                <a href="/views/dashboard.php" class="btn btn-primary">Volver al menú</a>
                </div>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <?php
        // Lista de calles clasificadas por color
        $calles_verde = [
            "VALENCIA",
            "PLAÇA LA CREU",
            "DOCTOR NAVARRO",
            "D. EMILIO RAMÓN LLIN",
            "SANTA BÀRBERA"
        ];

        $calles_rojo = [
            "TIRANT LO BLANC",
            "RAMÓN I CAJAL",
            "TARAZONA",
            "SANT BERTOMEU",
            "PUNTARRÓ",
            "REAL ACEQUIA DE MONCADA"
        ];

        $calles_amarillo = [
            "MESTRE PALAU",
            "LA NÒRIA",
            "POETA RICARDO VALERO",
            "8 DE MARÇ"
        ];

        $calles_azul = [
            "BONIFACI FERRER",
            "PRIMER DE MAIG (1-8)",
            "ANTONIO ESPOLIO",
            "PLAÇA NOU D’OCTUBRE",
            "SANT DÍDAC",
            "LA SÈQUIA",
            "CAVALLERS(1-36--47)",
            "VICENT LASSALA"
        ];

        $calles_gris = [
            "PLAÇA SANT JOAN DE RIBERA",
            "PL. ANTIC REGNE DE VALÈNCIA",
            "MAJOR",
            "ASSEGADORS",
            "RAJOLARS",
            "MESTRE SERRANO"
        ];

        $calles_morado = [
            "BLASCO IBAÑEZ",
            "SANT VICENT",
            "CALVARI",
            "CAVALLERS(38--49-FINAL)",
            "AUSIÀS MARCH",
            "PRIMER DE MAIG (19-FINAL)",
            "CAMÍ DE RAFELBUNYOL",

        ];

        // Función para generar los enlaces
        function generarEnlaces($calles, $color) {
            $html = '<div class="col-lg-3">'; // Inicio de la columna
            foreach ($calles as $calle) {
                $urlCalle = strtolower(str_replace(' ', '-', $calle)) . '.php'; // Agrega .php al final del nombre del archivo
                $html .= '<div class="row">';
                $html .= '<div class="col-lg-12">';
                if ($color == 'light') {
                    $html .= '<a href="/../views/modules/calles/' . urlencode($urlCalle) . '" class="btn btn-outline-secondary">' . $calle . '</a>';
                } else {
                    $html .= '<a href="/../views/modules/calles/' . urlencode($urlCalle) . '" class="btn btn-' . $color . '">' . $calle . '</a>';
                }
                $html .= '</div>';
                $html .= '</div>';
            }
            $html .= '</div>'; // Fin de la columna
            return $html;
        }

        ?>

    <style>
        body {
            background-color: #f8f9fa; /* Cambia el color de fondo del cuerpo */
        }

        .botones {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin: 20px auto 10px auto; /* más margen arriba y centrado */
            max-width: 600px;
        }

    </style>


        <!-- Renderizar los enlaces -->
        <div class="row">
            <?php echo generarEnlaces($calles_verde, 'success'); ?>
            <?php echo generarEnlaces($calles_rojo, 'danger'); ?>
            <?php echo generarEnlaces($calles_amarillo, 'warning'); ?>
            <?php echo generarEnlaces($calles_azul, 'primary'); ?>
            <?php echo generarEnlaces($calles_gris, 'default'); ?>
            <?php echo generarEnlaces($calles_morado, 'purple'); ?>
        </div>

<div class="botones">
    <a href="/views/modules/orden/azul.php" style="background: #007BFF;">Listado</a>
    <a href="/views/modules/orden/rojo.php" style="background: #DC3545;">Listado</a>
    <a href="/views/modules/orden/verde.php" style="background: #28A745;">Listado</a>
    <a href="/views/modules/orden/amarillo.php" style="background: #FFC107; color: black;">Listado</a>
    <a href="/views/modules/orden/gris.php" style="background: #6C757D;">Listado</a>
    <a href="/views/modules/orden/morado.php" style="background:rgb(154, 5, 184);">Listado</a>
</div>
    </div>
</body>
</html>
