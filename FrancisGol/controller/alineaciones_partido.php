<?php
    require_once "../model/alineaciones_partido.php";

    $titulo = "FrancisGol - Estadísticas partido";
    $lista_css = ["partidos_liga.css",  "alineaciones.css"];

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) {

        $partido = json_decode(urldecode($_GET["partido"]));;

        $idPartido = $partido->fixture->id;
        $idEquipoLocal = $partido->teams->home->id;
        $idEquipoVisitante = $partido->teams->away->id;

        $alineacionesPartido = recogerAlineacionesPartido($idPartido);
        $alineacionesPartido = pintarAlineacionesPartido($alineacionesPartido);

    } else {

        header("Location: ../controller/partidos.php");
        exit;
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/alineaciones_partido.php';
    include '../view/templates/footer.php';