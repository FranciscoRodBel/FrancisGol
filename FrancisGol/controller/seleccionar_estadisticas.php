<?php
    require_once "../model/realizar_consultas.php";
    require_once "../model/equipo_estadisticas.php";

    if (isset($_GET["idEquipo"]) && isset($_GET["anio"]) && isset($_GET["idCompeticion"])) {
        
        $idEquipo = $_GET["idEquipo"];
        $idCompeticion = $_GET["idCompeticion"];
        $anio = $_GET["anio"];

        $equipoEstadisticas = realizarConsulta("equipo_estadisticas_$idEquipo"."_"."$idCompeticion"."_"."$anio", "teams/statistics?league=$idCompeticion&season=$anio&team=$idEquipo", 86400); 
        echo pintarEstadisticasEquipo($equipoEstadisticas);

    }