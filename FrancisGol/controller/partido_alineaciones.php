<?php
    require_once "../model/Usuario.php";
    require_once "../model/Partido.php";
    require_once "../model/Jugador.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Estadísticas partido";
    $lista_css = ["partidos_liga.css",  "alineaciones.css"];

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) {

        $idPartido = $_GET["partido"];
        $partido = Partido::recogerPartido($idPartido);

        if (!empty($partido)) {
            $datosPartido = $partido->pintarPartido();
            
            $alineacionesPartido = realizarConsulta("partido_alineaciones_$idPartido", "fixtures/lineups?fixture=$idPartido", 1800); 

            if (!empty($alineacionesPartido)) {

                $alineacionesPartido = $partido->pintarAlineacionesPartido($alineacionesPartido);
            } else {

                $alineacionesPartido = "<p class='parrafo_informacion'>No se encontraron alineaciones</p>";
            }

            $nombreEquipoLocal = $partido->__get("nombreEquipoLocal");
            $nombreEquipoVisitante = $partido->__get("nombreEquipoVisitante");

        } else {

            $nombreEquipoLocal = "Equipo";
            $nombreEquipoVisitante = "Equipo";
            $datosPartido = "";
            $alineacionesPartido = "<p class='parrafo_informacion'>Partido no encontrado</p>";
        }

    } else {

        $nombreEquipoLocal = "Equipo";
        $nombreEquipoVisitante = "Equipo";
        $datosPartido = "";
        $alineacionesPartido = "<p class='parrafo_informacion'>Partido no encontrado</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partido_alineaciones.php';
    include '../view/templates/footer.php';