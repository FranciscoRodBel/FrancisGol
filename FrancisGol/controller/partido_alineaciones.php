<?php
    require_once "../model/partido_alineaciones.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Estadísticas partido";
    $lista_css = ["partidos_liga.css",  "alineaciones.css"];

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) {

        $partido = json_decode(urldecode($_GET["partido"]));;

        $idPartido = $partido->fixture->id;
        $idEquipoLocal = $partido->teams->home->id;
        $idEquipoVisitante = $partido->teams->away->id;
        
        $alineacionesPartido = realizarConsulta("partido_alineaciones_$idPartido", "fixtures/lineups?fixture=$idPartido", 86400); 

        $alineacionesPartido = pintarAlineacionesPartido($alineacionesPartido);

    } else {

        header("Location: ../controller/partidos.php");
        exit;
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partido_alineaciones.php';
    include '../view/templates/footer.php';