<?php
    include_once '../model/Usuario.php';

    Usuario::comprobarSesionIniciada(false);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_GET["accion"])) {

            $usuario = unserialize($_SESSION['usuario']);

            echo match ($_GET["accion"]) {
                "editarFoto" => $usuario->editarFoto(),
                default => "Datos enviados incorrectos"
            };
        }
      
    }