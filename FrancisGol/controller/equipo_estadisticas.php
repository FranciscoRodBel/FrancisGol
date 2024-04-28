<?php
    require_once "../model/Competicion.php";
    require_once "../model/equipo_estadisticas.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Equipo estadísticas";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["equipo"]) && !empty($_GET["equipo"])) {

        $idEquipo = $_GET["equipo"];
        $datosEquipo = Equipo::recogerEquipo($idEquipo);
        $equipoCompeticiones = Competicion::recogerEquipoCompeticiones($idEquipo); 
        $opcionesCompeticiones = generarOpcionesCompeticiones($equipoCompeticiones);
        $opcionesAnios = generarOpcionesAnios($equipoCompeticiones);

        $equipoEstadisticas = realizarConsulta("equipo_estadisticas_530", "teams/statistics?league=140&season=2023&team=530", 86400); 
        $tablaEstadisticas = pintarEstadisticasEquipo($equipoEstadisticas);
      
    } else {

        header("Location: ../controller/partidos.php");
        exit;
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/equipo_estadisticas.php';
    include '../view/templates/footer.php';