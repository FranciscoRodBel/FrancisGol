<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Registro";
    $lista_css = ["registro_inicio.css"];
    
    $paises = realizarConsulta("paises", "countries", 86400); 
    $paises2 = crearOpcionesPaises($paises);
    $paises1 = "<option value='' selected>Competiciones generales</option>".$paises2;

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/registro.php';
    include '../view/templates/footer.php';
