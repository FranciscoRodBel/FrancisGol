<?php
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/paises.php";
    require_once "../model/Competicion.php";
    
    $titulo = "FrancisGol - Competiciones";
    $lista_css = ["competiciones.css"];

    $paises = realizarConsulta("paises", "countries", 86400); 
    $paises = crearOpcionesPaises($paises);

    $resultadoCompeticiones = Competicion::pintarCompeticionesFavoritas();
    
    $resultadoEquipos = Equipo::pintarEquiposFavoritos();


    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/buscar.php';
    include '../view/templates/footer.php';