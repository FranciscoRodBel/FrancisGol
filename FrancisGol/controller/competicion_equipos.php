<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Competición equipos";
    $lista_css = ["competiciones.css"];

    $datosCompeticion = "<p class='parrafo_informacion_blanco'>No se encontró la competición.</p>"; // Si algún dato está vacío se muestra este mensaje
    $equiposCompeticion = "";

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) { // Si se ha enviado el id de la competición
        
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion); // Se recoge el objeto de la competición

        if (!empty($competicion)) { 

            $datosCompeticion = $competicion->pintarCompeticion(); // HTML con el logo y nombre de la competición
            $temporadasDisponibles = realizarConsulta("temporadas_disponibles_$idCompeticion", "leagues/seasons", 604800); // Se recogen los años disponibles de la competición

            if (!empty($temporadasDisponibles)) {

                $optionsAniosDisponibles = Competicion::generarOptionsTemporadas($temporadasDisponibles);
                $anioActual = date("Y") - 1;
                $equipos = realizarConsulta("competicion_equipos_".$idCompeticion."_".$anioActual, "teams?league=$idCompeticion&season=$anioActual", 86400); // Se recogen los equipos de la competición

                if (!empty($equipos)) {

                    $equiposCompeticion = $competicion->generarEquiposCompeticion($equipos); // Se genera el HTML que se muestra en la página
                }
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_equipos.php';
    include '../view/templates/footer.php';