<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_GET["competicion"]) && isset($_GET["anio"]) && !empty($_GET["competicion"]) && !empty($_GET["anio"])) { // Si se envían los datos correctamente por ajax...

        $anioActual = $_GET["anio"];
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion); // Se recoge el objeto de la competición

        $clasificacion = realizarConsulta("competicion_clasificacion_".$idCompeticion."_".$anioActual, "standings?league=$idCompeticion&season=$anioActual", 86400); // Recojo la clasificación de la competición

        if (empty($clasificacion)) {
            
            $tablaClasificacion = "<p class='parrafo_informacion'>No se encontraron resultados.</p>";

        } else {

            $tablaClasificacion = $competicion->generarClasificacion($clasificacion); // Se va generando el HTML para ver la clasificación
        }

    } else {

        $tablaClasificacion = "<p class='parrafo_informacion'>No se encontraron resultados.</p>";
    }

    echo $tablaClasificacion;