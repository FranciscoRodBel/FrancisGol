<?php
    require_once "../model/partido_estadisticas.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Estadísticas partido";
    $lista_css = ["partidos_liga.css"];

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) {

        $partido = json_decode(urldecode($_GET["partido"]));;

        $idPartido = $partido->fixture->id;
        $idEquipoLocal = $partido->teams->home->id;
        $idEquipoVisitante = $partido->teams->away->id;

        $estadisticasPartido = realizarConsulta("partido_estadisticas_$idPartido", "fixtures/statistics?fixture=$idPartido", 86400); 
        $tablaEstadisticas = pintarEstadisticasPartido($estadisticasPartido);

    } else {

        header("Location: ../controller/partidos.php");
        exit;
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partido_estadisticas.php';
    include '../view/templates/footer.php';