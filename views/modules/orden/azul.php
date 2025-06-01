<?php
session_start();
if(!$_SESSION["validar"]) {
    header("Location: http://10.224.24.247/recogida/");
    exit();
}

require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");

$usuariosController = new UsuariosController();

// Cambia estos nombres por todas las calles que quieras mostrar
$calles = ["bonifaci_ferrer", "primer_de_maig_1_8", "antonio_espolio", "plaza_nou_d_octubre", "sant_didac", "la_sequia", "cavallers_1_36_47"];

$usuariosPorCalle = [];
foreach ($calles as $calle) {
    $usuariosPorCalle[$calle] = $usuariosController->obtenerUsuariosPorCalleController($calle);
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

<h1>Listado completo Recorrido AZUL</h1>

<?php foreach($usuariosPorCalle as $calle => $usuarios): ?>
    <div class="calle-container">
        <h2>Calle: <?php echo ucwords(str_replace('_', ' ', $calle)); ?></h2>
        <div class="usuarios-listado" data-calle="<?php echo $calle; ?>">
            <?php foreach ($usuarios as $usuario) : ?>
                <div class="usuario">
                    <div class="numero">
                        <input type="text" />
                    </div>
                    <div class="numero"><?php echo htmlspecialchars($usuario['numero']); ?></div>
                    <div class="nombre"><?php echo htmlspecialchars($usuario['nombre']); ?></div>
                    <div class="bultos"><?php echo htmlspecialchars($usuario['regalos']); ?></div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
<?php endforeach; ?>

<button onclick="window.print()">Imprimir listado completo</button>
<button onclick="ordenarTodasCalles()">Ordenar todas las calles</button>


<script>
    function ordenarTodasCalles() {
    // Definimos el orden personalizado para cada calle
    const ordenesPorCalle = {
        "bonifaci_ferrer": [1, 3, 5, 2, 7, 4, 9, 6, 8, 11, 10, 13, 12, 14, 15, 16, 17, 18, 19, 20, 21, 22, 24, 23],
        "primer_de_maig_1_8": [8, 7, 6, 5, 4, 3, 2, 1],
        "antonio_espolio": [8, 6, 4, 2],
        "plaza_nou_d_octubre": [8, 9, 2],
        "sant_didac": [14, 12, 13, 11, 10, 9, 8, 7, 6, 5, 3, 4, 1, 2],
        "la_sequia": [1, 2, 4, 6, 8, 10, 3, 5, 7, 12, 13, 14, 9], 
        "cavallers_1_36_47": [10, 9, 11, 13, 15, 17, 12, 19, 14, 16, 21, 13, 18, 23, 25, 20, 22, 24, 29, 31, 26, 33, 28, 35, 30, 39, 41, 32, 43, 45, 34, 36, 6, 5, 4, 3, 2, 1]
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
