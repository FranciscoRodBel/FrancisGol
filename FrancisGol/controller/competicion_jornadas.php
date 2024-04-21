<?php
    require_once "../model/competicion_jornadas.php";
    require_once "../model/Competicion.php";
    require_once "../model/competiciones.php";

    $titulo = "FrancisGol - Competición";
    $lista_css = ["competiciones.css", "partidos_liga.css"];

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) {

        $idCompeticion = $_GET["competicion"];
        $datosCompeticion = Competicion::recogerCompeticion($idCompeticion);
        $clasificacion = recogerJornadas($idCompeticion);
        $datosJornadas = generarJornadas($clasificacion);
        $opcionesJornadas = $datosJornadas[0];
        $jornadas = $datosJornadas[1];

    } else {
    
        $datosCompeticion = "<p>No se encontró la competición<p>";
        $jornadas = "";
        $opcionesJornadas = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_jornadas.php';
    include '../view/templates/footer.php';