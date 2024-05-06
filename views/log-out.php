<?php
// Inicia sesión
session_start();

// Cierra la sesión
session_destroy();

// Redirige a la página de inicio
header("Location: ../index.php");
exit; // Asegura que el script se detenga después de la redirección
?>
