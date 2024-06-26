<?php
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    if (isset($_GET["idEquipo"]) && isset($_GET["anio"]) && isset($_GET["idCompeticion"]) && !empty($_GET["idEquipo"]) && !empty($_GET["anio"]) && !empty($_GET["idCompeticion"])) {
        
        $idEquipo = $_GET["idEquipo"];
        $idCompeticion = $_GET["idCompeticion"];
        $anio = $_GET["anio"];

        $equipo = Equipo::recogerEquipo($idEquipo); // Se recoge el objeto del equipo

        if (!empty($equipo)) {

            $equipoEstadisticas = realizarConsulta("equipo_estadisticas_$idEquipo"."_"."$idCompeticion"."_".$anio, "teams/statistics?league=$idCompeticion&season=$anio&team=$idEquipo", 86400); // Se recogen los las estadísticas de los equipos
        
            if (!empty($equipoEstadisticas)) {
                
                echo $equipo->pintarEstadisticasEquipo($equipoEstadisticas); // Se pintan las estadísticas del equipo
    
            }
        }

        echo "";
    }