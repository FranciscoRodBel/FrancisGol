<?php
    include_once '../model/Usuario.php';

    Usuario::comprobarSesionIniciada(true); // Si la sesión está iniciada lo redirige a la página de partidos

    if ($_SERVER["REQUEST_METHOD"] == "POST") { // Cuando inicie sesión viene aquí y...

        // Recoge el email y la contraseña enviada 
        $email = $_POST['email'];
        $contrasenia = $_POST['contrasenia'];

        $usuario = new Usuario($email); // Creo el objeto del usuario
        echo $usuario->comprobarInicioSesion($contrasenia, "inicio"); // Comprobará si la sesión es correcta, si es así iniciará sesión y si no, devolverá un mensaje indicando el error
    }