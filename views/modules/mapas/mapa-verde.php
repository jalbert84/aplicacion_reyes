<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mapa Verde</title>
    <style>
        /* Estilos para el contenedor principal */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        /* Estilos para el contenedor del mapa */
        #map-container {
            width: 90vw; /* Cambia el ancho según tus necesidades */
            height: 90vh; /* Cambia la altura según tus necesidades */
            position: relative; /* Posición relativa para contener el mapa */
            cursor: grab; /* Cambiar el cursor a la mano cuando se puede arrastrar */
        }

        /* Estilos para la imagen del mapa */
        #map-image {
            display: block;
            width: 100%;
            height: auto;
            position: absolute; /* Posición absoluta para ajustar la imagen */
            top: 0;
            left: 0;
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
        <button class="back-button" onclick="window.location.href = 'javascript:history.back()'">Volver a atrás</button>

    <!-- Contenedor principal del mapa -->
    <div id="map-container">
        <!-- Imagen del mapa verde -->
        <img id="map-image" src="mapa_rei_verd.jpg" alt="Mapa Verde">
    </div>

    <script>
        // Obtener la imagen y el contenedor de la imagen
        var mapImage = document.getElementById('map-image');
        var mapContainer = document.getElementById('map-container');
        var lastScale = 1;
        var isDragging = false;
        var startX, startY, startTranslateX, startTranslateY;

        // Función para manejar el evento de rueda del mouse (zoom)
        function zoomImage(e) {
            e.preventDefault();
            var delta = e.deltaY || e.detail || e.wheelDelta;
            var scaleChange = 1 - delta / 1000; // Invertir el movimiento para ampliar y disminuir
            lastScale *= scaleChange;

            // Calcular el desplazamiento del punto de clic
            var rect = mapContainer.getBoundingClientRect();
            var mouseX = e.clientX - rect.left;
            var mouseY = e.clientY - rect.top;

            // Calcular la diferencia entre la posición del ratón y el punto de origen del contenedor
            var offsetX = mouseX - mapContainer.clientWidth / 2;
            var offsetY = mouseY - mapContainer.clientHeight / 2;

            // Calcular el desplazamiento necesario para mantener el punto de clic en la misma posición relativa dentro del contenedor
            var deltaX = offsetX * scaleChange - offsetX;
            var deltaY = offsetY * scaleChange - offsetY;

            // Aplicar la transformación
            mapImage.style.transform = 'scale(' + lastScale + ') translate(' + deltaX + 'px, ' + deltaY + 'px)';
        }

        // Función para manejar el inicio del arrastre
        function startDrag(e) {
            e.preventDefault();
            isDragging = true;
            startX = e.clientX;
            startY = e.clientY;
            startTranslateX = parseFloat(mapImage.style.transform.split('(')[1].split('px')[0]);
            startTranslateY = parseFloat(mapImage.style.transform.split(',')[1].split('px')[0]);
            mapContainer.style.cursor = 'grabbing'; // Cambiar el cursor a la mano cerrada mientras se arrastra
        }

        // Función para manejar el arrastre
        function drag(e) {
            e.preventDefault();
            if (isDragging) {
                var deltaX = e.clientX - startX;
                var deltaY = e.clientY - startY;
                mapImage.style.transform = 'scale(' + lastScale + ') translate(' + (startTranslateX + deltaX) + 'px, ' + (startTranslateY + deltaY) + 'px)';
            }
        }

        // Función para manejar el final del arrastre
        function endDrag(e) {
            e.preventDefault();
            isDragging = false;
            mapContainer.style.cursor = 'grab'; // Restaurar el cursor a la mano abierta después de arrastrar
        }

        // Agregar oyentes de eventos para el zoom y el arrastre
        mapContainer.addEventListener('wheel', zoomImage);
        mapImage.addEventListener('mousedown', startDrag);
        window.addEventListener('mousemove', drag);
        window.addEventListener('mouseup', endDrag);
    </script>
</body>
</html>
