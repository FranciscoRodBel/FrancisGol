<?php
    session_start();
    require_once "../model/Usuario.php";

    if (isset($_SESSION['usuario'])) {

        if (isset($_GET['accion']) && !empty($_GET['accion'])) {
        
            $usuario = unserialize($_SESSION['usuario']);

            if ($_GET['accion'] == "aceptar") {
            
                $usuario->guardarCookies();
                $usuario->crearCookies();
            }

            $usuario->__set("cookies", "1");
            $_SESSION['usuario'] = serialize($usuario);
        }
    }