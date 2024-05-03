<?php
    session_start();
    require_once "../model/Partido.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Estadísticas partido";
    $lista_css = ["partidos_liga.css"];

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) {

        $idPartido = $_GET["partido"];
        $partido = Partido::recogerPartido($idPartido);
        $datosPartido = $partido->pintarPartido();

        $estadisticasPartido = realizarConsulta("partido_estadisticas_$idPartido", "fixtures/statistics?fixture=$idPartido", 86400); 
        $tablaEstadisticas = $partido->pintarEstadisticasPartido($estadisticasPartido);

        $nombreEquipoLocal = $partido->__get("nombreEquipoLocal");
        $nombreEquipoVisitante = $partido->__get("nombreEquipoVisitante");

    } else {

        header("Location: ../controller/partidos.php");
        exit;
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partido_estadisticas.php';
    include '../view/templates/footer.php';