<?php
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    if (isset($_GET["idEquipo"]) && isset($_GET["anio"]) && isset($_GET["idCompeticion"])) {
        
        $idEquipo = $_GET["idEquipo"];
        $idCompeticion = $_GET["idCompeticion"];
        $anio = $_GET["anio"];

        $equipo = Equipo::recogerEquipo($idEquipo);

        $equipoEstadisticas = realizarConsulta("equipo_estadisticas_$idEquipo"."_"."$idCompeticion"."_".$anio, "teams/statistics?league=$idCompeticion&season=$anio&team=$idEquipo", 604800); 
        
        if (!empty($equipoEstadisticas)) {
            
            echo $equipo->pintarEstadisticasEquipo($equipoEstadisticas);

        } else {

            echo "";

        }
    }