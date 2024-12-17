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

// Obtener los usuarios de la calle BonifaciFerrer
$usuariosController = new UsuariosController();
$usuariosBonifaciFerrer = $usuariosController->obtenerUsuariosPorCalleController("bonifaci_ferrer");

$orden = 1;
foreach ($usuariosBonifaciFerrer as &$usuario) {
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
            $mensaje = $usuariosController->actualizarOrdenUsuariosController($usuariosOrdenados, 'bonifaciferrer');
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
    <title>Carrer Bonifaci Ferrer</title>
    
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
            flex: 2; /* 10% del ancho total */
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
            justify-content: flex-start; /* Alinear elementos al inicio */
            }

            .actions-container input[type="number"] {
            margin-right: -400px; /* Espacio entre el campo de entrada y el primer botón */
            }
        

        /* Estilos para el botón de imprimir y actualizar */
        .boton {
            display: block;
            margin: 5px auto;
        }

 @media print {
    /* Ocultar todo el contenido excepto la tabla */
    .container {
        visibility: hidden;
        position: fixed;
    }

    .usuario {
        display: flex;
        border: 1px solid #000; /* Borde exterior igual al de las celdas internas */
        padding: 0; /* Sin padding para evitar espacio extra */
        margin: 0; /* Eliminar márgenes */
        page-break-inside: avoid; /* Evitar saltos de página dentro de un usuario */
    }

    /* Agregar bordes y estilos para hacer que se vea como una tabla */
    .usuario div {
        border: 1px solid #000; /* Borde para cada celda */
        padding: 5px; /* Espacio interno */
    }

    /* Añadir borde inferior entre filas */
    .usuario:not(:last-child) {
        border-bottom: none; /* Eliminar borde inferior extra */
    }

    /* Mostrar el título en la primera página y en la parte superior */
    h1 {
        display: block;
        text-align: center; /* Centrar el título */
        margin: 0;
        page-break-before: always 1; /* Asegura que el título esté en la primera página */
    }

    .boton-container, .actions-container, .no-print {
        display: none; /* Ocultar botones y elementos no imprimibles */
    }

    .usuario:first-child {
        margin-top: 30px; /* Ajustar el margen superior del primer usuario */
    }

    .usuario:nth-child(26) {
        page-break-after: always; /* Insertar un salto de página después de cierto número de usuarios */
    }

    .btn-mapa-azul {
        display: none; /* Ocultar el botón del mapa en la impresión */
    }
    
    .btn-primary {
        display: none; /* Ocultar el botón de volver al menu */
    }

    .remove-btn {
        display: none; /* Ocultar el botón X */
    }

    h4 {
        display: block !important;
        visibility: visible !important;
        margin: 0;
    }
}
    </style>
</head>
<body>

    <a href="/../views/modules/usuarios/listar-usuarios.php" class="btn btn-primary no-print">Volver al Listado de Calles</a>
    <a href="/views/dashboard.php" class="btn btn-primary">Volver al menú</a>
    <a href="/../views/modules/mapas/mapa-azul.php" class="btn-mapa-azul">Mapa</a>

    <h1 class="text-center" style="color: white;">Carrer Bonifaci Ferrer</h1>
    <h4 style="display: none;">POSICIÓN__NÚMERO_________________NOMBRE_______________________BULTOS</h4>
    <div class="actions-container">
    <input type="number" id="numeroInicial" min="1" value="1" size="4" placeholder="Número de lista">
    <button class="boton" onclick="actualizarNumeros()">Posición</button>
    <button class="boton" id="imprimirButton" onclick="imprimirUsuarios()">Imprimir</button>
    </div>

    <div class="boton-container">
    <button class="boton" id="moverHaciaArribaButton" onclick="moverUsuariosHaciaArriba()">Mover hacia arriba</button>
    <button class="boton" id="guardarCambiosButton" onclick="guardarOrdenUsuarios()">Guardar Cambios</button>
    </div>

    <?php if (!empty($usuariosBonifaciFerrer)) : ?>
    <div id="usuarios" class="usuarios-container">
        <?php 
        // Obtener el último usuario
        $ultimoUsuario = end($usuariosBonifaciFerrer);
        
        // Reiniciar el puntero del array
        reset($usuariosBonifaciFerrer);
        
        // Mostrar todos los usuarios excepto el último
        for ($i = 0; $i < count($usuariosBonifaciFerrer) - 1; $i++) : 
            $usuario = $usuariosBonifaciFerrer[$i];
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
            <div><?php echo count($usuariosBonifaciFerrer); ?></div>
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
    <p>No se encontraron usuarios registrados en la calle BonifaciFerrer.</p>
<?php endif; ?>

<script>
function eliminarUsuarioTemporalmente(event) {
// Obtener el contenedor del usuario al que se le hizo clic
    var usuario = event.target.closest('.usuario');
// Ocultar el usuario de forma temporal (sin eliminarlo del DOM)
    usuario.style.display = 'none';
}     

var usuariosOrdenados = [];

// Función para mover hacia arriba las líneas de usuario seleccionadas
function moverUsuariosHaciaArriba() {
    // Obtener las líneas de usuario
    var usuarios = document.querySelectorAll('.usuario');
    // Crear un array para almacenar los IDs de los usuarios en el orden actual
    usuariosOrdenados = [];
    // Iterar sobre las líneas de usuario para obtener el orden actual
    usuarios.forEach(function(usuario) {
        usuariosOrdenados.push(usuario.getAttribute('data-id'));
    });
    // Mover las líneas de usuario seleccionadas hacia arriba en el DOM
    usuarios.forEach(function(usuario, index) {
        if (usuario.classList.contains('seleccionado')) {
            var anterior = usuario.previousElementSibling;
            if (anterior) {
                usuario.parentNode.insertBefore(usuario, anterior);
            }
        }
    });
}

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

// Asignar el evento clic a cada línea de usuario para manejar la selección
document.querySelectorAll('.usuario').forEach(function(usuario) {
    usuario.addEventListener('click', function() {
        toggleSeleccion(this);
    });
});

// Función para seleccionar/deseleccionar una línea de usuario
function toggleSeleccion(usuario) {
    var seleccionadas = document.querySelectorAll('.usuario.seleccionado');
    seleccionadas.forEach(function(seleccionada) {
        if (seleccionada !== usuario) {
            seleccionada.classList.remove('seleccionado');
        }
    });
    
    if (!usuario.classList.contains('seleccionado')) {
        usuario.classList.add('seleccionado');
    } else {
        usuario.classList.remove('seleccionado');
    }
}

function guardarOrdenUsuarios() {
    // Obtener todas las líneas de usuario
    var usuarios = document.querySelectorAll('.usuario');
    // Crear un array para almacenar los IDs de los usuarios en el orden actual
    usuariosOrdenados = [];
    // Iterar sobre todas las líneas de usuario y agregar sus IDs al arreglo de usuarios ordenados
    usuarios.forEach(function(usuario) {
        usuariosOrdenados.push(usuario.getAttribute('data-id'));
    });
    
    // Enviar una solicitud AJAX al servidor con el orden de los usuarios
    fetch('./bonifaci-ferrer.php', {
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

</script>


</body>
</html>
