<?php
if (!isset($_SESSION)) session_start(); 
if (!$_SESSION["validar"]) {
    header("Location: http://10.224.24.247/recogida/");
    exit();
}
require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");

$usuariosController = new UsuariosController();
$usuariostarazona = $usuariosController->obtenerUsuariosPorCalleController("tarazona");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['usuariosEditados'])) {
        try {
            foreach ($data['usuariosEditados'] as $usuario) {
                $usuariosController->editarUsuarioDesdeVista($usuario['id'], $usuario['numero'], $usuario['nombre'], $usuario['regalos']);
            }
            echo json_encode(["success" => true]);
            exit();
        } catch (Exception $e) {
            echo json_encode(["error" => $e->getMessage()]);
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrer 8 de març</title>
    <link href="/views/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f7f7f7;
            font-family: sans-serif;
            padding: 20px;
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .botones {
            display: flex;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }
        .usuario {
            display: flex;
            gap: 10px;
            background: white;
            padding: 10px;
            border-radius: 10px;
            margin-bottom: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .usuario input {
            flex: 1;
            padding: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        #guardar {
            display: block;
            margin: 30px auto;
        }
    </style>
</head>
<body>

    <div class="botones">
        <a href="/../views/modules/usuarios/listar-usuarios.php" class="btn btn-primary">Volver al listado de calles</a>
        <a href="/views/dashboard.php" class="btn btn-primary">Volver al menú</a>
        <a href="/../views/modules/mapas/mapa-rojo.php" class="btn btn-danger">Mapa</a>
    </div>

    <h1>Carrer 8 de març</h1>
    <button id="guardar" class="btn btn-success">Guardar cambios</button>
    <?php if (!empty($usuariostarazona)) : ?>
        <div id="usuarios">
            <?php foreach ($usuariostarazona as $usuario): ?>
                <div class="usuario" data-id="<?= $usuario['id'] ?>">
                    <input type="text" name="numero" value="<?= htmlspecialchars($usuario['numero']) ?>">
                    <input type="text" name="nombre" value="<?= htmlspecialchars($usuario['nombre']) ?>">
                    <input type="text" name="regalos" value="<?= htmlspecialchars($usuario['regalos']) ?>">
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <p>No se encontraron usuarios en esta calle.</p>
    <?php endif; ?>

<script>
document.getElementById("guardar").addEventListener("click", () => {
    const usuariosEditados = Array.from(document.querySelectorAll('.usuario')).map(div => {
        return {
            id: div.dataset.id,
            numero: div.querySelector('input[name="numero"]').value,
            nombre: div.querySelector('input[name="nombre"]').value,
            regalos: div.querySelector('input[name="regalos"]').value
        };
    });

    fetch('./8-de-marÇ.php', {
        method: 'POST',
        body: JSON.stringify({ usuariosEditados }),
        headers: { 'Content-Type': 'application/json' }
    })
    .then(r => r.json())
    .then(resp => {
        if (resp.success) {
            alert("Cambios guardados correctamente.");
        } else {
            alert("Error: " + (resp.error || "desconocido"));
        }
    })
    .catch(e => alert("Error al guardar: " + e.message));
});
</script>

</body>
</html>
