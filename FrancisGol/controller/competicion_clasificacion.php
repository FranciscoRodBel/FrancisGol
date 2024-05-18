<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Competición clasificación";
    $lista_css = ["competiciones.css"];

    $datosCompeticion = "<p class='parrafo_informacion'>No se encontró la competición.</p>"; // Si algún dato está vacío se muestra este mensaje
    $tablaClasificacion = "";

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) { // Si se envía el id de la competición...
        
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion); // Se recoge el objeto de la competición

        if (!empty($competicion)) {

            $temporadasDisponibles = realizarConsulta("temporadas_disponibles_$idCompeticion", "leagues/seasons", 604800); // Recojo los años disponibles de los equipos

            if (!empty($temporadasDisponibles)) {

                $optionsAniosDisponibles = Competicion::generarOptionsTemporadas($temporadasDisponibles);
                $datosCompeticion = $competicion->pintarCompeticion(); // HTML con el logo y nombre de la competición

                $anioActual = date("Y") - 1;
                $clasificacion = realizarConsulta("competicion_clasificacion_".$idCompeticion."_".$anioActual, "standings?league=$idCompeticion&season=$anioActual", 86400); // Recojo la clasificación de la competición

                if (!empty($clasificacion)) {

                    $tablaClasificacion = $competicion->generarClasificacion($clasificacion); // Se genera el HTML que se muestra en la página
                }
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_clasificacion.php';
    include '../view/templates/footer.php';