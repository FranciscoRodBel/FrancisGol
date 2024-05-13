<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Competición jornadas";
    $lista_css = ["competiciones.css", "partidos_liga.css"];

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) {

        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion);

        if (!empty($competicion)) {

            $datosCompeticion = $competicion->pintarCompeticion();
            
            $anioActual = date("Y") - 1;
            $jornadasCompeticion = realizarConsulta("competicion_jornadas_".$idCompeticion."_".$anioActual, "fixtures?league=$idCompeticion&season=$anioActual", 86400); 
            $datosJornadas = $competicion->generarJornadas($jornadasCompeticion);
            $opcionesJornadas = $datosJornadas[0];
            $jornadas = $datosJornadas[1];

            $temporadasDisponibles = realizarConsulta("temporadasDisponibles", "leagues/seasons", 86400);
            $optionsAniosDisponibles = Competicion::generarOptionsTemporadas($temporadasDisponibles);

        } else {

            $datosCompeticion = "<p class='parrafo_informacion_blanco'>No se encontró la competición</p>";
            $jornadas = "";
            $opcionesJornadas = "";
        }

    } else {
    
        $datosCompeticion = "<p class='parrafo_informacion_blanco'>No se encontró la competición</p>";
        $jornadas = "";
        $opcionesJornadas = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_jornadas.php';
    include '../view/templates/footer.php';