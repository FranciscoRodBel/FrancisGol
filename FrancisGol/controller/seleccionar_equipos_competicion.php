<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_GET["competicion"]) && isset($_GET["anio"]) && !empty($_GET["competicion"]) && !empty($_GET["anio"])) {

        $anioActual = $_GET["anio"];
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion);

        $equipos = realizarConsulta("competicion_equipos_$idCompeticion"."_".$anioActual, "teams?league=$idCompeticion&season=$anioActual", 86400); 

        if (empty($equipos)) {
            
            $equipos_competicion = "<p class='parrafo_informacion'>No se encontraron resultados</p>";

        } else {

            $equipos_competicion = $competicion->generarEquiposCompeticion($equipos);
        }

    } else {

        $equipos_competicion = "";
    }

    echo $equipos_competicion;