<?php
    include_once '../model/Usuario.php';

    Usuario::comprobarSesionIniciada(true);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = $_POST['email'];
        $contrasenia = $_POST['contrasenia'];

        $usuario = new Usuario($email); // Creo el objeto del usuario
        echo $usuario->comprobarInicioSesion($contrasenia, "inicio"); // Comprobará si la sesión es correcta, si es así iniciará sesión y si no, devolverá un mensaje indicando el error
    }