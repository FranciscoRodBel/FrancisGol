<?php
    session_start();
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Competición jornadas";
    $lista_css = ["competiciones.css", "partidos_liga.css"];

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) {

        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion);
        $datosCompeticion = $competicion->pintarCompeticion($competicion);

        $jornadasCompeticion = realizarConsulta("competicion_jornadas_$idCompeticion", "fixtures?league=$idCompeticion&season=2023", 86400); 
        $datosJornadas = $competicion->generarJornadas($jornadasCompeticion);
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