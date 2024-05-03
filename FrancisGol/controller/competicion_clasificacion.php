<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Competición clasificación";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) {

        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion);
        $datosCompeticion = $competicion->pintarCompeticion($competicion);

        $clasificacion = realizarConsulta("competicion_clasificacion_$idCompeticion", "standings?league=$idCompeticion&season=2023", 86400); 

        $tablaClasificacion = $competicion->generarClasificacion($clasificacion);

    } else {
    
        $datosCompeticion = "<p>No se encontró la competición<p>";
        $tablaClasificacion = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_clasificacion.php';
    include '../view/templates/footer.php';