<?php
    // Cuando se redirige a este archivo automaticamente se cierra sesion y se redirige a la página de partidos

    session_start(); // Se inicia la sesión

    // Se borra la sesión
    session_unset(); 
    session_destroy();

    // Elimino las cookies para que al volver a inciar la página no se le incie la sesión
    setcookie("email", "", time() - 1, "/");
    setcookie("contrasenia", "", time() - 1, "/");

    header("Location: ./partidos.php");
    die();