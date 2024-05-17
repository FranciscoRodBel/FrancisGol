<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Competición clasificación";
    $lista_css = ["competiciones.css"];

    $datosCompeticion = "<p class='parrafo_informacion'>No se encontró la competición</p>";
    $tablaClasificacion = "";

    if (isset($_GET["competicion"]) && !empty($_GET["competicion"])) {
        
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion);

        if (!empty($competicion)) {

            $temporadasDisponibles = realizarConsulta("temporadas_disponibles_$idCompeticion", "leagues/seasons", 604800);

            if (!empty($temporadasDisponibles)) {

                $optionsAniosDisponibles = Competicion::generarOptionsTemporadas($temporadasDisponibles);
                $datosCompeticion = $competicion->pintarCompeticion();

                $anioActual = date("Y") - 1;
                $clasificacion = realizarConsulta("competicion_clasificacion_{$idCompeticion}_{$anioActual}", "standings?league=$idCompeticion&season=$anioActual", 86400);

                if (!empty($clasificacion)) {

                    $tablaClasificacion = $competicion->generarClasificacion($clasificacion);
                }
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competicion_clasificacion.php';
    include '../view/templates/footer.php';