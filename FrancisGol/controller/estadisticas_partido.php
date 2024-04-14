<?php
    require_once "../model/estadisticas_partido.php";

    $titulo = "FrancisGol - Estadísticas partido";
    $lista_css = ["partidos_liga.css"];

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) {

        $partido = json_decode(urldecode($_GET["partido"]));;

        $idPartido = $partido->fixture->id;
        $idEquipoLocal = $partido->teams->home->id;
        $idEquipoVisitante = $partido->teams->away->id;

        $estadisticasPartido = recogerEstadisticasPartido($idPartido);
        $tablaEstadisticas = pintarEstadisticasPartido($estadisticasPartido);

    } else {

        header("Location: ../controller/partidos.php");
        exit;
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/estadisticas_partido.php';
    include '../view/templates/footer.php';