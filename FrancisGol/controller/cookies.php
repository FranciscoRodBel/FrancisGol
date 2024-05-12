<?php
    $mensajeCookies = "";

    if (isset($_SESSION['usuario'])) {

        $usuario = unserialize($_SESSION['usuario']);

        if ($usuario->__get("cookies") == 0) {
            
            $mensajeCookies = $usuario->generarMensajeCookies();
        }

    } else {

        if(isset($_COOKIE['email']) && isset($_COOKIE['contrasenia'])) {

            $email = $_COOKIE['email'];
            $contrasenia = $_COOKIE['contrasenia'];

            $usuario = new Usuario($email);
            $usuario->comprobarInicioSesion($contrasenia, "cookie");

        }
    }