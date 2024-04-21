<?php
    require_once "../model/competicion_clasificacion.php";
    require_once "../model/Competicion.php";
    require_once "../model/competiciones.php";

    $titulo = "FrancisGol - Competición";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) {

        $idCompeticion = $_GET["competicion"];
        $datosCompeticion = Competicion::recogerCompeticion($idCompeticion);
        $clasificacion = recogerClasificacion($idCompeticion);
        $tablaClasificacion = generarClasificacion($clasificacion);

    } else {
    
        $datosCompeticion = "<p>No se encontró la competición<p>";
        $tablaClasificacion = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_clasificacion.php';
    include '../view/templates/footer.php';