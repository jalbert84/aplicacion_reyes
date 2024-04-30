<?php

// Activar errores
ini_set('display_errors', 'On');
ini_set('display_errors', 1);

require_once "../models/main-model.php";
require_once "../controllers/main-controller.php";

$controller = new MainController();
$controller->pagina();