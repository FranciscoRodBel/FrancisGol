<?php
    session_start();
    require_once "../model/Partido.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Estadísticas partido";
    $lista_css = ["partidos_liga.css",  "alineaciones.css"];

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) {

        $idPartido = $_GET["partido"];
        $partido = Partido::recogerPartido($idPartido);
        $datosPartido = $partido->pintarPartido();
        
        $alineacionesPartido = realizarConsulta("partido_alineaciones_$idPartido", "fixtures/lineups?fixture=$idPartido", 86400); 

        $alineacionesPartido = $partido->pintarAlineacionesPartido($alineacionesPartido);

        $nombreEquipoLocal = $partido->__get("nombreEquipoLocal");
        $nombreEquipoVisitante = $partido->__get("nombreEquipoVisitante");

    } else {

        header("Location: ../controller/partidos.php");
        exit;
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partido_alineaciones.php';
    include '../view/templates/footer.php';