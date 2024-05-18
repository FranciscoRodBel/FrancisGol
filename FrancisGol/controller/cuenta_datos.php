<?php
    require_once "../model/Usuario.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

    $titulo = "FrancisGol - Cuenta datos";
    $lista_css = ["registro_inicio.css", "competiciones.css"];

    $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario

    // Recojo los datos que se van a mostrar en los inputs
    $emailUsuario = $usuario->__get("email");
    $nombreUsuario = $usuario->__get("nombre");
    $fotoUsuario = $usuario->__get("foto");
    
    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/cuenta_datos.php';
    include '../view/templates/footer.php';