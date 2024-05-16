<?php
    require_once "../model/Usuario.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    Usuario::comprobarSesionIniciada(false);

    $titulo = "FrancisGol - Cuenta favoritos";
    $lista_css = ["registro_inicio.css", "competiciones.css"];

    $paises2 = crearOpcionesPaises();
    $paises1 = "<option value='' selected>Competiciones generales</option>".$paises2;

    $usuario = unserialize($_SESSION['usuario']);

    $fotoUsuario = $usuario->__get("foto");

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/cuenta_favoritos.php';
    include '../view/templates/footer.php';