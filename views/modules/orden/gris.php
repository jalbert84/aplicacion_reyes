<?php
session_start();
if(!$_SESSION["validar"]) {
    header("Location: http://10.224.24.247/recogida/");
    exit();
}

require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");

$usuariosController = new UsuariosController();

$numerosPorTramo = [
        'plaza_sant_joan_de_ribera_1' => [1, 6, 7, 10, 9, 8],
        'plaza_antic_regne_de_valencia_1' => [7, 8, 9, 10, 11, 12, 13, 14, 6, 5, 4, 3, 2, 1],
        'doctor_navarro_1' => [46, 27, 48],
        'major_1' => [1, 2, 3, 4, 5, 7, 6, 8, 9, 11, 10, 13, 12, 17, 14, 15],
        'don_emilio_ramon_llin_1' => [36, 53, 38, 55, 59, 61, 63],
        'major_2' => [16, 17, 19, 21, 18, 20, 23, 22, 27, 29, 24, 30, 31, 26, 33, 28, 30, 35, 32, 34, 36, 37, 38, 39, 40, 41, 43, 42, 45, 47, 44, 49, 51, 46, 48, 53, 50, 52, 57, 54, 56, 58, 60, 62], 
        'assegadors_1' => [1, 2, 3, 4, 5, 6],
        'major_3' => [64, 66, 68, 70, 72],
        'rajolars_1' => [1, 3, 5],
        'major_4' => [76, 78],
        'mestre_serrano_1' => [15, 17],
        'major_5' => [82, 84, 86, 88]
];

// Cambia estos nombres por todas las calles que quieras mostrar
$calles = ["plaza_sant_joan_de_ribera", "plaza_antic_regne_de_valencia", "doctor_navarro", "major", "don_emilio_ramon_llin", "major", "assegadors", "major", "rajolars", "major", "mestre_serrano"];

$usuariosPorCalle = [];
$repeticiones = [];

foreach ($calles as $calle) {

    if (!isset($repeticiones[$calle])) {
        $repeticiones[$calle] = 1;
    } else {
        $repeticiones[$calle]++;
    }

    $claveTramo = $calle . '_' . $repeticiones[$calle];

    $usuarios = $usuariosController->obtenerUsuariosPorCalleController($calle);

    // Filtramos solo los usuarios que estén en la lista de números del tramo
    if (isset($numerosPorTramo[$claveTramo])) {
        $usuarios = array_filter($usuarios, function($u) use ($numerosPorTramo, $claveTramo) {
            return in_array((int)$u['numero'], $numerosPorTramo[$claveTramo]);
        });
    }

    $usuariosPorCalle[] = [
        'nombre' => $calle,
        'tramo' => $claveTramo,
        'usuarios' => $usuarios
    ];
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8" />
<div class="noprint"><a href="/../views/modules/usuarios/listar-usuarios.php">↩ Tornar</a></div>
<title>llistat complet de usuarios por calles</title>
<style>
    body { font-family: Arial, sans-serif; background: white; color: black; }
    h1, h2 { text-align: center; }
    h2 {
    margin-top: 40px;
    margin-bottom: 20px;
    }
    .calle-container { margin-bottom: 40px; }
    .usuario {
        display: flex;
        padding: 5px 10px;
        border-bottom: 5px solid #ddd;
        align-items: center;
        white-space: nowrap; /* evita que el texto se parta en varias líneas */
        text-overflow: ellipsis; /* agrega "..." si el texto es muy largo */
    }
    .usuario div {
        padding: 0 5px;
    }
    .usuario div.numero {
        width: 80px; 
        flex: none;
        display: flex;
        justify-content: center;
    }
    .usuario div.numero input {
        width: 50px;
        border: 1px solid #999;
        padding: 3px 5px;
        font-size: 16px;
        text-align: center;
        background: white;
    }
    .usuario div.nombre {
        flex: 1.2; /* más grande que regalos */
        text-align: center;
    }
    .usuario div.bultos {
        width: 110px; 
        flex: none;
        text-align: center;
    }
    @media print {
        a, button, h1, .noprint { display: none; }
        .usuario div.numero input {
            border: 1px solid black;
            background: white;
        }
    }
</style>
</head>
<body>

<h1>llistat complet Recorregut GRIS</h1>

<?php foreach ($usuariosPorCalle as $datos): ?>
    <div class="calle-container">
        <h2>Carrer: <?= ucwords(str_replace('_', ' ', $datos['nombre'])) ?></h2>
        <div class="usuarios-llistat" data-calle="<?= $datos['tramo'] ?>">
            <?php foreach ($datos['usuarios'] as $usuario): ?>
                <div class="usuario">
                    <div class="numero"><input type="text" /></div>
                    <div class="numero"><?= htmlspecialchars($usuario['numero']) ?></div>
                    <div class="nombre"><?= htmlspecialchars($usuario['nombre']) ?></div>
                    <div class="bultos"><?= htmlspecialchars($usuario['regalos']) ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>

<button onclick="window.print()">Imprimir llistat complet</button>
<button onclick="ordenarTodasCalles()">Ordenar todas las calles</button>


<script>
    function ordenarTodasCalles() {
    // Definimos el orden personalizado para cada calle
    const ordenesPorCalle = {
        "plaza_sant_joan_de_ribera_1": [1, 6, 7, 10, 9, 8],
        "plaza_antic_regne_de_valencia_1": [7, 8, 9, 10, 11, 12, 13, 14, 6, 5, 4, 3, 2, 1],
        "doctor_navarro_1": [46, 27, 48],
        "major_1": [1, 2, 3, 4, 5, 7, 6, 8, 9, 11, 10, 13, 12, 17, 14, 15],
        "don_emilio_ramon_llin_1": [36, 53, 38, 55, 59, 61, 63],
        "major_2": [16, 17, 19, 21, 18, 20, 23, 22, 27, 29, 24, 30, 31, 26, 33, 28, 30, 35, 32, 34, 36, 37, 38, 39, 40, 41, 43, 42, 45, 47, 44, 49, 51, 46, 48, 53, 50, 52, 57, 54, 56, 58, 60, 62], 
        "assegadors_1": [1, 2, 3, 4, 5, 6],
        "major_3": [64, 66, 68, 70, 72],
        "rajolars_1": [1, 3, 5],
        "major_4": [76, 78],
        "mestre_serrano_1": [15, 17],
        "major_5": [82, 84, 86, 88]
    };

document.querySelectorAll('.usuarios-llistat').forEach(container => {
        const calle = container.getAttribute('data-calle');
        const ordenPersonalizado = ordenesPorCalle[calle] || [];

        const usuarios = Array.from(container.querySelectorAll('.usuario'));
        const mapaUsuarios = {};

        usuarios.forEach(usuario => {
            const numero = parseInt(usuario.querySelector('div.numero:nth-of-type(2)').textContent.trim());
            if (!mapaUsuarios[numero]) mapaUsuarios[numero] = [];
            mapaUsuarios[numero].push(usuario);
        });

        container.innerHTML = '';
        ordenPersonalizado.forEach(numero => {
            if (mapaUsuarios[numero]) {
                mapaUsuarios[numero].forEach(usuario => container.appendChild(usuario));
            }
        });
    });
}
</script>
</body>
</html>
