<?php
    include_once '../model/Usuario.php';

    Usuario::comprobarSesionIniciada(true); // Si la sesión está iniciada lo redirige a la página de partidos

    $titulo = "FrancisGol - Inicio de sesión";
    $lista_css = ["registro_inicio.css"];

    include_once '../view/templates/head.php';
    include_once '../view/templates/header.php';
    include '../view/templates/nav_inicio_registro.php';
    include_once '../view/inicioSesion.php';
    include_once '../view/templates/footer.php';
