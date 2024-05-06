<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Competición equipos";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) {

        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion);
        $datosCompeticion = $competicion->pintarCompeticion($competicion);
        
        $equipos = realizarConsulta("competicion_equipos_$idCompeticion"."_"."2023", "teams?league=$idCompeticion&season=2023", 86400); 
        $equiposCompeticion = $competicion->generarEquiposCompeticion($equipos);

    } else {
    
        $datosCompeticion = "<p>No se encontró la competición<p>";
        $equiposCompeticion = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_equipos.php';
    include '../view/templates/footer.php';