<?php
session_start();
if(!$_SESSION["validar"]) {
    header("Location: http://10.224.24.247/recogida/");
    exit();
}

require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");

$usuariosController = new UsuariosController();

// Cambia estos nombres por todas las calles que quieras mostrar
$calles = ["valencia", "plaza_la_creu", "doctor_navarro", "don_emilio_ramon_llin", "santa_barbera"];

$usuariosPorCalle = [];
foreach ($calles as $calle) {
    $usuariosPorCalle[] = [
        'nombre' => $calle,
        'usuarios' => $usuariosController->obtenerUsuariosPorCalleController($calle)
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

<h1>llistat complet Recorregut VERD</h1>

<?php
$repeticiones = [];
foreach ($usuariosPorCalle as $index => $datos) {
    $calle = $datos['nombre'];
    // Aumenta el contador para cada calle
    if (!isset($repeticiones[$calle])) {
        $repeticiones[$calle] = 1;
    } else {
        $repeticiones[$calle]++;
    }
    $claveCalle = $calle . '_' . $repeticiones[$calle];
?>
    <div class="calle-container">
        <h2>Carrer: <?php echo ucwords(str_replace('_', ' ', $calle)); ?></h2>
        <div class="usuarios-llistat" data-calle="<?php echo $claveCalle; ?>">
            <?php foreach ($datos['usuarios'] as $usuario) : ?>
                <div class="usuario">
                    <div class="numero"><input type="text" /></div>
                    <div class="numero"><?php echo htmlspecialchars($usuario['numero']); ?></div>
                    <div class="nombre"><?php echo htmlspecialchars($usuario['nombre']); ?></div>
                    <div class="bultos"><?php echo htmlspecialchars($usuario['regalos']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php } ?>

<button onclick="window.print()">Imprimir llistat completos</button>
<button onclick="ordenarTodasCalles()">Ordenar todas las calles</button>


<script>
    function ordenarTodasCalles() {
    // Definimos el orden personalizado para cada calle
    const ordenesPorCalle = {
        "valencia_1": [2, 1, 4, 3, 6, 5, 7, 8, 10, 9, 11, 12, 13, 14],
        "plaza_la_creu_1": [5, 6, 7, 1, 2, 3, 4],
        "doctor_navarro_1": [1, 2, 4, 6, 8, 10, 12, 14, 16, 18, 20, 7, 22, 9, 24, 11, 26, 13, 15, 28, 30, 32, 34, 36, 38, 17, 19, 42],
        "don_emilio_ramon_llin_1": [34, 51, 49, 32, 45, 43, 41, 39, 37, 35, 33, 31, 28, 29, 27, 26, 25, 24, 23, 22, 21, 19, 20, 18, 17, 15, 16, 13, 14, 11, 12, 10, 9, 7, 8, 5, 6, 3, 4, 1, 2],
        "santa_barbera_1": [47, 44, 45, 42, 43, 40, 38, 41, 39, 36, 37, 35, 33, 34, 31, 29, 28, 27, 26, 25, 24, 23, 21, 19, 18, 17, 15, 16, 13, 14, 11, 12, 9, 7, 10, 8, 5, 6, 4, 2]
    };

    const contenedores = document.querySelectorAll('.usuarios-llistat');

    contenedores.forEach(container => {
        const calle = container.getAttribute('data-calle');
        const ordenPersonalizado = ordenesPorCalle[calle] || [];

        const usuarios = Array.from(container.querySelectorAll('.usuario'))
            .filter(u => u.style.display !== 'none');

        const mapaUsuarios = {};
        usuarios.forEach(usuario => {
            const numeroTexto = usuario.querySelector('div.numero:nth-of-type(2)').textContent.trim();
            const numero = parseInt(numeroTexto);
            if (!mapaUsuarios[numero]) {
                mapaUsuarios[numero] = [];
            }
            mapaUsuarios[numero].push(usuario);
        });

        container.innerHTML = '';

        let pos = 1;
        ordenPersonalizado.forEach(numero => {
            if (mapaUsuarios[numero]) {
                mapaUsuarios[numero].forEach(usuario => {
                    const input = usuario.querySelector('div.numero input');
                    container.appendChild(usuario);
                });
            }
        });
    });
}
</script>
</body>
</html>
