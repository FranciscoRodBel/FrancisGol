<?php
    include_once '../model/Usuario.php';

    Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

    if ($_SERVER["REQUEST_METHOD"] == "POST") { // Si se realiza algún envío por POST

        if (isset($_GET["accion"])) { // Si se ha enviado la acción(Lo que se quiere editar)

            $usuario = unserialize($_SESSION['usuario']); // Se recoge el usuario

            echo match ($_GET["accion"]) { // Se comprueba que se quiere editar y se llama a la función que realiza la operación y devuelve un mensaje con lo realizado
                "editarFoto" => $usuario->editarFoto(),
                "editarDatos" => $usuario->editarDatos(),
                "editarContrasenia" => $usuario->editarContrasenia(),
                default => "Datos enviados incorrectos"
            };
        }
      
    }