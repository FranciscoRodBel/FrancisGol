<?php
    require_once "../model/Usuario.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    Usuario::comprobarSesionIniciada(false);

    $titulo = "FrancisGol - Cuenta datos";
    $lista_css = ["registro_inicio.css", "competiciones.css"];

    $usuario = unserialize($_SESSION['usuario']);

    $emailUsuario = $usuario->__get("email");
    $nombreUsuario = $usuario->__get("nombre");
    $fotoUsuario = $usuario->__get("foto");

    
    
    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/cuenta_datos.php';
    include '../view/templates/footer.php';