<?php
session_start();
if(!$_SESSION["validar"]) {
    header("Location: http://10.224.24.247/recogida/");
    exit();
}

require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");

$usuariosController = new UsuariosController();

// Cambia estos nombres por todas las calles que quieras mostrar
$calles = ["mestre_palau", "poeta_ricardo_valero", "la_noria", "mestre_palau", "poeta_ricardo_valero", "8_de_marzo", "poeta_ricardo_valero"];

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

<h1>Listado completo Recorrido AMARILLO</h1>

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
        "mestre_palau_1": [2, 4, 6, 1, 8, 10, 3, 12, 5, 14, 16, 7, 9, 18, 20, 22, 11, 24, 13, 26, 28, 15],
        "poeta_ricardo_valero_1": [18, 20, 22, 24, 25, 23, 21, 19, 17, 16],
        "la_noria_1": [9, 18, 7, 16, 14, 12, 5, 3, 10, 1, 8, 6, 4, 2, 11, 13, 15, 17, 22, 24, 26],
        "mestre_palau_2": [50, 48, 46, 44, 42, 40, 38, 36, 34, 32, 30, 17],
        "poeta_ricardo_valero_2": [14, 15, 13, 11, 12, 10, 9],
        "8_de_marzo_1": [6, 5, 4, 3, 2, 1, 8, 7, 10, 9, 12, 11, 14], 
        "poeta_ricardo_valero_3": [8, 7, 6, 5, 4, 3, 2, 1]
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
