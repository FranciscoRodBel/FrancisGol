<?php
    session_start();

    // cuando se redirige a este archivo automaticamente se cierra sesion y se redirige a la página de partidos

    session_unset();
    session_destroy();

    setcookie("email", "", time() - 1, "/");
    setcookie("contrasenia", "", time() - 1, "/");

    header("Location: ./partidos.php");
    die();