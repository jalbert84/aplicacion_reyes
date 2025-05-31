<?php
session_start();
if(!$_SESSION["validar"]) {
    header("Location: http://10.224.24.247/recogida/");
    exit();
}

require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");

$usuariosController = new UsuariosController();

// Cambia estos nombres por todas las calles que quieras mostrar
$calles = ["blasco_ibanyez", "sant_vicent", "cavallers_38_49_final", "sant_vicent", "ausias_march", "sant_vicent", "primer_de_maig_19_final", "cami_de_rafelbunyol"];

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
<div class="noprint"><a href="/../views/modules/usuarios/listar-usuarios.php">↩ Volver</a></div>
<title>Listado completo de usuarios por calles</title>
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
    }
    .usuario div {
        padding: 0 5px;
    }
    .usuario div.numero {
        width: 50px; 
        flex: none;
        display: flex;
        justify-content: center;
    }
    .usuario div.numero input {
        width: 40px;
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
        width: 80px; 
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

<h1>Listado completo Recorrido MORADO</h1>

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
        <h2>Calle: <?php echo ucwords(str_replace('_', ' ', $calle)); ?></h2>
        <div class="usuarios-listado" data-calle="<?php echo $claveCalle; ?>">
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

<button onclick="window.print()">Imprimir listado completo</button>
<button onclick="ordenarTodasCalles()">Ordenar todas las calles</button>


<script>
    function ordenarTodasCalles() {
    // Definimos el orden personalizado para cada calle
    const ordenesPorCalle = {
        "blasco_ibanyez_1": [10, 8, 6, 2],
        "sant_vicent_1": [78, 76, 74, 72, 70, 77, 75, 73, 68, 66, 64, 58],
        "calvari": [1, 2, 3, 4, 5, 7, 6, 8, 9, 11, 10, 13, 12, 17, 14, 15],
        "sant_vicent_2": [63, 56, 61, 54, 59, 57, 55, 53],
        "cavallers_38_49_final_1": [38, 49, 51, 40, 42, 53, 55, 57, 59, 61, 63, 65, 67, 46, 48, 69, 71, 73, 75, 77, 79, 81, 83, 85, 87, 89, 91, 93, 95, 97, 99],
        "sant_vicent_3": [51, 52, 50, 49, 48, 46, 47, 44, 45, 42, 40, 43, 39, 38, 37, 36, 35, 34, 32, 30, 28, 26, 24],
        "ausias_march_1": [13, 11, 9, 7, 5, 6, 4, 3, 2],
        "sant_vicent_4": [20, 18, 23, 21, 16, 19, 17, 15, 14, 13, 12, 11, 10, 9, 8, 7, 6, 5, 4, 3, 2, 1], 
        "primer_de_maig_19_final_1": [19, 20, 21, 22, 34, 35, 36, 37, 38, 39, 40, 41, 42],
        "cami_de_rafelbunyol_1": [8, 6]
    };

    const contenedores = document.querySelectorAll('.usuarios-listado');

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
