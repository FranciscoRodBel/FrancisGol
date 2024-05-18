<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_GET["competicion"]) && isset($_GET["anio"]) && !empty($_GET["competicion"]) && !empty($_GET["anio"])) {

        $anioActual = $_GET["anio"];
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion); // Se recoge el objeto de la competición

        $equipos = realizarConsulta("competicion_equipos_$idCompeticion"."_".$anioActual, "teams?league=$idCompeticion&season=$anioActual", 604800); // Se recogen los equipos de la competición

        if (empty($equipos)) {
            
            $equipos_competicion = "<p class='parrafo_informacion'>No se encontraron resultados</p>";

        } else {

            $equipos_competicion = $competicion->generarEquiposCompeticion($equipos); // Genera el HTML de los equipos 
        }

    } else {

        $equipos_competicion = "<p class='parrafo_informacion'>No se encontraron resultados</p>";
    }

    echo $equipos_competicion;