<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Competición jornadas";
    $lista_css = ["competiciones.css", "partidos_liga.css"];

    $datosCompeticion = "<p class='parrafo_informacion_blanco'>No se encontró la competición.</p>"; // Si algún dato está vacío se muestra este mensaje
    $jornadas = "";
    $opcionesJornadas = "";

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) { // Si se ha enviado el id de la competición
        
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion); // Se recoge el objeto de la competición

        if (!empty($competicion)) {

            $temporadasDisponibles = realizarConsulta("temporadas_disponibles_$idCompeticion", "leagues/seasons", 604800); // Se recogen los años disponibles de la competición

            if (!empty($temporadasDisponibles)) {

                $optionsAniosDisponibles = Competicion::generarOptionsTemporadas($temporadasDisponibles);
                $datosCompeticion = $competicion->pintarCompeticion(); // HTML con el logo y nombre de la competición

                $anioActual = date("Y") - 1;
                $jornadasCompeticion = realizarConsulta("competicion_jornadas_".$idCompeticion."_".$anioActual, "fixtures?league=$idCompeticion&season=$anioActual", 86400); // Recojo las jornadas de las competiciones

                if (!empty($jornadasCompeticion)) {

                    $datosJornadas = $competicion->generarJornadas($jornadasCompeticion); // Se genera el HTML que se muestra en la página y las opciones de las jornadas
                    $opcionesJornadas = $datosJornadas[0]; // HTML de las opciones
                    $jornadas = $datosJornadas[1]; // HTML de los enfrentamientos de las jornadas
                }
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_jornadas.php';
    include '../view/templates/footer.php';