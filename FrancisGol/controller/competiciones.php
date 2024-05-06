<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    
    $titulo = "FrancisGol - Competiciones";
    $lista_css = ["competiciones.css"];

    $competiciones = realizarConsulta("competiciones", "leagues", 86400); 

    $resultadoCompeticiones = Competicion::pintarCompeticiones($competiciones);

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competiciones.php';
    include '../view/templates/footer.php';