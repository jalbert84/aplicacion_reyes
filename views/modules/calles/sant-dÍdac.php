<?php
// Iniciar sesión si no está iniciada
if (!isset($_SESSION)) { 
    session_start(); 
} 

// Verificar si el usuario está autenticado
if(!$_SESSION["validar"]) {  
    header("Location: http://10.224.24.247/recogida/"); // Redirigir al usuario si no está autenticado
    exit();
}

// Incluir el controlador de usuarios
require_once("C:/Users/jorge/Documents/amics_reis/aplicacion/aplicacion_reyes/controllers/usuarios/user-controller.php");

// Obtener los usuarios de la calle SantDidac
$usuariosController = new UsuariosController();
$usuariosSantDidac = $usuariosController->obtenerUsuariosPorCalleController("sant_didac");

$orden = 1;
foreach ($usuariosSantDidac as &$usuario) {
    $usuario['orden'] = $orden; // Asignar un orden inicial basado en el orden en que aparecen los registros
    $orden++;
}

/// Evento para guardar cambios en el orden de los usuarios
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el JSON enviado desde el frontend
    $data = json_decode(file_get_contents("php://input"), true);

    // Verificar si se recibió el orden de los usuarios
    if (isset($data['usuariosOrdenados'])) {
        $usuariosOrdenados = $data['usuariosOrdenados'];

        // Actualizar el orden de los usuarios en la base de datos utilizando el controlador
        try {
            $mensaje = $usuariosController->actualizarOrdenUsuariosController($usuariosOrdenados, 'santdidac');
            // Imprimir un script JavaScript para mostrar el mensaje emergente
            echo '<script>alert("Cambios guardados correctamente.");</script>';
            exit(); // Salir del script después de enviar la respuesta
        } catch (Exception $e) {
            // Imprimir un script JavaScript para mostrar el mensaje emergente con el error
            echo '<script>alert("Error al guardar los cambios: ' . $e->getMessage() . '");</script>';
            exit(); // Salir del script en caso de error
        }
    }
}


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrer Sant Dídac</title>
    
    <!-- GLOBAL STYLES -->
    <link href="/views/css/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Ubuntu:300,400,500,700,300italic,400italic,500italic,700italic' rel="stylesheet" type="text/css">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800' rel="stylesheet" type="text/css">
    <link href="/views/icons/font-awesome/css/font-awesome.min.css" rel="stylesheet">

    <!-- THEME STYLES -->
    <link href="/views/css/style.css" rel="stylesheet">
    <link href="/views/css/plugins.css" rel="stylesheet">
    <style>
        .btn-mapa-azul {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
        }
        /* Estilos para los usuarios */
        .usuario, .usuario div {
            user-select: none; /* Evita la selección de texto */
            font-size: 16px; /* Ajusta el tamaño de la fuente */
        }
        .usuario {
            display: flex;
            justify-content: flex-start; /* Alinea los elementos a la izquierda */
            background-color: #fff; /* Fondo blanco */
            color: #333; /* Texto oscuro */
            padding: 10px;
            margin-bottom: 8px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); /* Sombra */
            cursor: pointer; /* Cambia el cursor al hacer hover */
        }
        .usuario:hover {
            background-color: #f0f0f0; /* Cambia el color de fondo al hacer hover */
        }
        .seleccionado {
            background-color: #c8e6c9; /* Cambia el color de fondo cuando está seleccionado */
        }
       
        .arrastrando {
            opacity: 0.5;
        }
        .sobre {
            border: 2px dashed #00f;
        }

        /* Ajuste del ancho de las columnas */
        .usuario div:nth-child(1) {
            flex: 1; /* 10% del ancho total */
        }

        .usuario div:nth-child(2) {
            flex: 2; /* 50% del ancho total */
        }

        .usuario div:nth-child(3) {
            flex: 5; /* 30% del ancho total */
        }

        .usuario div:nth-child(4) {
            flex: 3; /* 10% del ancho total */
        }

        .boton-container {
        display: flex; /* Utilizar Flexbox para alinear los botones horizontalmente */
        }

        .boton {
        margin-right: 10px; /* Espacio entre los botones */
        }

        /* Estilos para la línea seleccionada */
        .usuario.seleccionado {
        background-color: #c8e6c9; /* Cambia el color de fondo cuando está seleccionado */
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.5); /* Agrega una sombra cuando está seleccionado */
        }

        /* Estilos para el título */
        h1 {
            text-align: center;
            margin-top: 15px;
        }

        .actions-container {
            display: flex;        
            }

        .actions-container input[type="number"] {
            margin-right: -200px; /* Espacio entre el campo de entrada y el primer botón */
        }

        /* Estilos para el botón de imprimir y actualizar */
        .boton {
            display: block;
            margin: 5px auto;
        }

        @media print {
    /* Estilo para el título principal */
    h1 {
        text-align: center; /* Centrar el título */
        top: 0; /* Ubicar en la parte superior de la página */
        margin: 0;
        width: 100%; /* Asegurar que ocupe todo el ancho */
        background: white; /* Fondo blanco para evitar superposición */
        z-index: 1000; /* Asegurar que esté encima */
    }

    /* Estilo para el subtítulo */
    h4 {
        display: block !important;
        visibility: visible !important;
        top: 1.2cm; /* Colocar debajo del h1 */
        margin: 0;
    }

     /* Estilo general para los usuarios */
     .usuario {
        border: 1px solid #000;
        padding: 0;
        margin-top: 0;
        margin-bottom: 0;
    }

    /* Agregar bordes y estilos para hacer que se vea como una tabla */
    .usuario div {
        border: 1px solid #000; /* Borde para cada celda */
        padding: 5px; /* Espacio interno */
    }

    .usuario:nth-child(n+27) {
        display: none;
    }

    /* Ocultar botones y otros elementos no imprimibles */
    .boton-container, .actions-container, .no-print, .btn-mapa-amarillo, .btn-primary, .remove-btn, .btn-mapa-azul {
        display: none; /* Ocultar botones y elementos no imprimibles */
    }
}
    </style>
</head>
<body>

    <a href="/../views/modules/usuarios/listar-usuarios.php" class="btn btn-primary no-print">Volver al Listado de Calles</a>
    <a href="/views/dashboard.php" class="btn btn-primary">Volver al menú</a>
    <a href="/../views/modules/mapas/mapa-azul.php" class="btn-mapa-azul">Mapa</a>

    <h1 class="text-center" style="color: white;">Carrer Sant Dídac</h1>
    <h4 style="display: none;">POSICIÓN__NÚMERO_________________NOMBRE__________________BULTOS</h4>
    <div class="actions-container">
    <input type="number" id="numeroInicial" size="3" placeholder="Número de Posición">
    <button class="boton" onclick="actualizarNumeros()">Actualizar Posición</button>
    <button class="boton" id="guardarCambiosButton" onclick="guardarOrdenUsuarios()">Guardar Cambios</button>
    <button class="boton" id="imprimirButton" onclick="imprimirUsuarios()">Imprimir</button>
    <button class="boton" id="ordenarAutomaticamente" onclick="ordenarAutomaticamente()">Ordenar Automáticamente</button>
    </div>

    <?php if (!empty($usuariosSantDidac)) : ?>
    <div id="usuarios" class="usuarios-container">
        <?php 
        // Obtener el último usuario
        $ultimoUsuario = end($usuariosSantDidac);
        
        // Reiniciar el puntero del array
        reset($usuariosSantDidac);
        
        // Mostrar todos los usuarios excepto el último
        for ($i = 0; $i < count($usuariosSantDidac) - 1; $i++) : 
            $usuario = $usuariosSantDidac[$i];
        ?>
            <div class="usuario" data-id="<?php echo $usuario['id']; ?>">
                <div><?php echo $i + 1; ?></div>
                <?php if (isset($usuario['numero'])) : ?>
                    <div><?php echo $usuario['numero']; ?></div>
                <?php endif; ?>
                <?php if (isset($usuario['nombre'])) : ?>
                    <div><?php echo $usuario['nombre']; ?></div>
                <?php endif; ?>
                <?php if (isset($usuario['regalos'])) : ?>
                    <div><?php echo $usuario['regalos']; ?></div>
                <?php endif; ?>
                <button class="remove-btn" onclick="eliminarUsuarioTemporalmente(event)">X</button>
            </div>
        <?php endfor; ?>
        <!-- Mostrar el último usuario -->
        <div class="usuario" data-id="<?php echo $ultimoUsuario['id']; ?>">
            <div><?php echo count($usuariosSantDidac); ?></div>
            <?php if (isset($ultimoUsuario['numero'])) : ?>
                <div><?php echo $ultimoUsuario['numero']; ?></div>
            <?php endif; ?>
            <?php if (isset($ultimoUsuario['nombre'])) : ?>
                <div><?php echo $ultimoUsuario['nombre']; ?></div>
            <?php endif; ?>
            <?php if (isset($ultimoUsuario['regalos'])) : ?>
                <div><?php echo $ultimoUsuario['regalos']; ?></div>
            <?php endif; ?>
            <button class="remove-btn" onclick="eliminarUsuarioTemporalmente(event)">X</button>
        </div>
    </div>
<?php else : ?>
    <p>No se encontraron usuarios registrados en la calle SantDidac.</p>
<?php endif; ?>

<script>
function eliminarUsuarioTemporalmente(event) {
// Obtener el contenedor del usuario al que se le hizo clic
    var usuario = event.target.closest('.usuario');
// Ocultar el usuario de forma temporal (sin eliminarlo del DOM)
    usuario.style.display = 'none';
}     

var usuariosOrdenados = [];

// Función para imprimir los usuarios
function imprimirUsuarios() {
    // Obtener el número inicial ingresado por el usuario
    var numeroInicial = parseInt(document.getElementById('numeroInicial').value);
    // Asignar números secuenciales a las líneas de usuario
    var usuarios = document.querySelectorAll('.usuario');
    usuarios.forEach(function(usuario, index) {
        usuario.querySelector('div:first-child').textContent = numeroInicial + index;
    });
    // Ocultar el botón de impresión para evitar que se imprima
    document.getElementById('imprimirButton').style.display = 'none';
    // Imprimir los usuarios
    window.print();
    // Restaurar la visibilidad del botón de impresión después de imprimir
    document.getElementById('imprimirButton').style.display = 'block';
}

// Función para actualizar los números de lista de las líneas de usuario
function actualizarNumeros() {
    // Obtener el número inicial ingresado por el usuario
    var numeroInicial = parseInt(document.getElementById('numeroInicial').value);
    // Asignar números secuenciales a las líneas de usuario
    var usuarios = document.querySelectorAll('.usuario');
    usuarios.forEach(function(usuario, index) {
        usuario.querySelector('div:first-child').textContent = numeroInicial + index;
    });
}

document.querySelectorAll('.usuario').forEach(function(usuario) {
    usuario.setAttribute('draggable', true);

    usuario.addEventListener('dragstart', function(event) {
        event.dataTransfer.setData('text/plain', usuario.getAttribute('data-id'));
        usuario.classList.add('arrastrando');
    });

    usuario.addEventListener('dragover', function(event) {
        event.preventDefault();
        usuario.classList.add('sobre');
    });

    usuario.addEventListener('dragleave', function() {
        usuario.classList.remove('sobre');
    });

    usuario.addEventListener('drop', function(event) {
        event.preventDefault();
        usuario.classList.remove('sobre');
        
        const idArrastrado = event.dataTransfer.getData('text/plain');
        const usuarioArrastrado = document.querySelector(`.usuario[data-id='${idArrastrado}']`);
        const contenedor = document.getElementById('usuarios');
        
        if (usuarioArrastrado && usuario !== usuarioArrastrado) {
            contenedor.insertBefore(usuarioArrastrado, usuario.nextSibling);
        }
    });

    usuario.addEventListener('dragend', function() {
        usuario.classList.remove('arrastrando');
    });
});

// Función para guardar el nuevo orden después de arrastrar y soltar
function guardarOrdenUsuarios() {
    const usuarios = document.querySelectorAll('.usuario');
    const usuariosOrdenados = Array.from(usuarios).map(usuario => usuario.getAttribute('data-id'));
    
    // Enviar una solicitud AJAX al servidor con el orden de los usuarios
    fetch('./sant-dÍdac.php', {
        method: 'POST',
        body: JSON.stringify({ usuariosOrdenados: usuariosOrdenados }),
        headers: {
            'Content-Type': 'application/json'
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error al guardar el orden de los usuarios.');
        }
        return response.text(); // Devolver la respuesta del servidor
    })
    .then(data => {
        console.log(data); // Mostrar la respuesta del servidor en la consola (puedes cambiar esto según tu necesidad)
        mostrarMensaje('Cambios guardados correctamente.');
    })
    .catch(error => {
        console.error('Error:', error); // Manejar cualquier error que ocurra durante la solicitud AJAX
    });
}


// Función marcador para actualizar el orden del usuario en el backend
function actualizarOrdenUsuario(idUsuario, nuevoOrden) {
    // Esta función no realiza ninguna acción específica en el cliente
    // Su propósito es indicar la actualización del orden del usuario en el backend
}

function mostrarMensaje(mensaje) {
    // Crear un elemento div para el mensaje emergente
    var popup = document.createElement('div');
    popup.textContent = mensaje;
    popup.classList.add('popup');
    popup.style.color = 'white'; // Establecer el color del texto en blanco
    popup.style.position = 'absolute'; // Posicionar el mensaje de forma absoluta
    popup.style.top = '50px'; // Ajustar la posición vertical para que aparezca sobre el título
    popup.style.left = '50%'; // Centrar horizontalmente el mensaje
    popup.style.transform = 'translateX(-50%)'; // Centrar horizontalmente el mensaje
    popup.style.background = 'rgba(0, 0, 0, 0.5)'; // Fondo semitransparente
    
    // Agregar el mensaje emergente al cuerpo del documento
    document.body.appendChild(popup);
    
    // Desaparecer el mensaje después de 3 segundos
    setTimeout(function() {
        popup.style.display = 'none';
        // Eliminar el elemento del DOM después de ocultarlo
        document.body.removeChild(popup);
    }, 3000);
}

function ordenarAutomaticamente() {
    const usuariosContainer = document.getElementById('usuarios');
    const usuarios = Array.from(usuariosContainer.querySelectorAll('.usuario'))
        .filter(u => u.style.display !== 'none');

    // Crear un mapa con numero => array de divs
    const mapaUsuarios = {};
    usuarios.forEach(usuario => {
        const numero = parseInt(usuario.querySelector('div:nth-child(2)').textContent.trim());
        if (!mapaUsuarios[numero]) {
            mapaUsuarios[numero] = [];
        }
        mapaUsuarios[numero].push(usuario);
    });

    // Orden personalizado
    const ordenPersonalizado = [14, 12, 13, 11, 10, 9, 8, 7, 6, 5, 3, 4, 1, 2];

    // Limpia el contenedor
    usuariosContainer.innerHTML = '';

    // Añade en orden todos los usuarios que correspondan a cada número
    let pos = 1;
    ordenPersonalizado.forEach(numero => {
        if (mapaUsuarios[numero]) {
            mapaUsuarios[numero].forEach(usuario => {
                usuario.querySelector('div:first-child').textContent = pos++; // Reasigna el orden visual
                usuariosContainer.appendChild(usuario);
            });
        }
    });

    // Añade los que no estaban en el patrón (por si acaso hay algún número fuera del patrón)
    Object.keys(mapaUsuarios).forEach(numero => {
        if (!ordenPersonalizado.includes(parseInt(numero))) {
            mapaUsuarios[numero].forEach(usuario => {
                usuario.querySelector('div:first-child').textContent = pos++;
                usuariosContainer.appendChild(usuario);
            });
        }
    });
}

</script>


</body>
</html>
