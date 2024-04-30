<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa Azul</title>
    <style>
        /* Establecer estilos para el contenedor principal */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            overflow: hidden; /* Ocultar desbordamiento */
        }

        /* Establecer estilos para el contenedor de la imagen */
        #map-container {
            width: 100%;
            height: 100%;
            overflow: auto; /* Habilitar barras de desplazamiento */
            cursor: pointer; /* Cursor de puntero */
            position: relative; /* Posición relativa para contener la imagen */
        }

        /* Establecer estilos para la imagen */
        #map-image {
            display: block; /* Eliminar espacio adicional debajo de la imagen */
            margin: auto; /* Centrar la imagen horizontalmente */
            transition: transform 0.3s ease; /* Efecto de transición suave */
            position: absolute; /* Posición absoluta para no mover la imagen */
            top: 0; /* Alinear la parte superior de la imagen con la parte superior del contenedor */
            left: 0; /* Alinear la parte izquierda de la imagen con la parte izquierda del contenedor */
            transform-origin: top left; /* Establecer el origen de la transformación en la esquina superior izquierda */
        }

        /* Estilo del botón para volver a la página de recorridos */
        .back-button {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 9999;
            padding: 10px 20px;
            background-color: #007bff; /* Color azul */
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3; /* Cambio de color al pasar el ratón */
        }
    </style>
</head>
<body>
    <!-- Botón para volver a la página de recorridos -->
    <button class="back-button" onclick="window.location.href = '../usuarios/recorridos.php'">Volver a Recorridos</button>

    <!-- Contenedor principal del mapa -->
    <div id="map-container">
        <!-- Imagen del mapa azul -->
        <img id="map-image" src="mapa-prueba.jpg" alt="Mapa Azul">
    </div>

    <script>
        // Obtener la imagen y el contenedor de la imagen
        var mapImage = document.getElementById('map-image');
        var mapContainer = document.getElementById('map-container');
        var lastScale = 1;

        // Función para manejar el evento de rueda del mouse (zoom)
        function zoomImage(e) {
            e.preventDefault();
            var delta = e.deltaY || e.detail || e.wheelDelta;
            lastScale *= (1 - delta / 1000); // Invertir el movimiento para ampliar y disminuir
            mapImage.style.transform = 'scale(' + lastScale + ')';
        }

        // Agregar oyente de eventos para el zoom
        mapContainer.addEventListener('wheel', zoomImage);
    </script>
    
</body>
</html>
