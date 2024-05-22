<?php
    require_once "../model/Usuario.php";

    Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

    $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario

    $usuario->borrarCuenta(); // Borra la cuenta, si hay un error muestra el mensaje de error

    header("Location: ./cerrarSesion.php");
    die();