<?php

class MainModel {

    public static function linksPagesModel($p_linkModel) {

        if ($p_linkModel == "alta-usuario" || $p_linkModel == "baja-usuario" || $p_linkModel == "modi-usuario" || $p_linkModel == "listar-usuarios" ) {
            $l_module = "modules/usuarios/" . $p_linkModel . ".php";
        } elseif ($p_linkModel == "logout" || $p_linkModel == "inicio") {
            $l_module = "modules/" . $p_linkModel . ".php";
        } elseif ($p_linkModel == "dashboard") {
            $l_module = "modules/dashboard.php";
        } elseif ($p_linkModel == "recorridos") {
            $l_module = "modules/recorridos.php";    
        } else {
            $l_module = "modules/inicio.php";
        }

        return $l_module;
    }

}
