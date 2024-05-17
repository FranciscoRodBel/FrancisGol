<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_GET["competicion"]) && isset($_GET["anio"]) && !empty($_GET["competicion"]) && !empty($_GET["anio"])) {

        $anioActual = $_GET["anio"];
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion);

        $clasificacion = realizarConsulta("competicion_clasificacion_".$idCompeticion."_".$anioActual, "standings?league=$idCompeticion&season=$anioActual", 86400); 

        if (empty($clasificacion)) {
            
            $tablaClasificacion = "<p class='parrafo_informacion'>No se encontraron resultados</p>";

        } else {

            $tablaClasificacion = $competicion->generarClasificacion($clasificacion);
        }

    } else {

        $tablaClasificacion = "<p class='parrafo_informacion'>No se encontraron resultados</p>";
    }

    echo $tablaClasificacion;