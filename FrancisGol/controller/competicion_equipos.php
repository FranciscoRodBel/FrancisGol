<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Competición equipos";
    $lista_css = ["competiciones.css"];

    $datosCompeticion = "<p class='titulo_informacion'>No se encontró la competición</p>";
    $equiposCompeticion = "";

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) {
        
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion);

        if (!empty($competicion)) {

            $datosCompeticion = $competicion->pintarCompeticion();
            $temporadasDisponibles = realizarConsulta("temporadas_disponibles_$idCompeticion", "leagues/seasons", 604800);

            if (!empty($temporadasDisponibles)) {

                $optionsAniosDisponibles = Competicion::generarOptionsTemporadas($temporadasDisponibles);
                $anioActual = date("Y") - 1;
                $equipos = realizarConsulta("competicion_equipos_{$idCompeticion}_{$anioActual}", "teams?league=$idCompeticion&season=$anioActual", 86400);

                if (!empty($equipos)) {

                    $equiposCompeticion = $competicion->generarEquiposCompeticion($equipos);
                }
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_equipos.php';
    include '../view/templates/footer.php';