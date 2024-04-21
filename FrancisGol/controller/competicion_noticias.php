<?php
    require_once "../model/competicion_noticias.php";
    require_once "../model/Competicion.php";
    require_once "../model/competiciones.php";

    $titulo = "FrancisGol - Competición";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) {

        $idCompeticion = $_GET["competicion"];
        $datosCompeticion = Competicion::recogerCompeticion($idCompeticion);

    } else {
    
        $datosCompeticion = "<p>No se encontró la competición<p>";

    }


    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_noticias.php';
    include '../view/templates/footer.php';