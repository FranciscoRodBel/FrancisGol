<?php
    require_once "../model/Usuario.php";
    require_once "../model/Partido.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Estadísticas partido";
    $lista_css = ["partidos_liga.css"];

    $nombreEquipoLocal = "Equipo";
    $nombreEquipoVisitante = "Equipo";
    $datosPartido = "";
    $tablaEstadisticas = "<p class='parrafo_informacion'>Partido no encontrado</p>";

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) {

        $idPartido = $_GET["partido"];
        $partido = Partido::recogerPartido($idPartido);
        
        if (!empty($partido)) {

            $datosPartido = $partido->pintarPartido();
            $estadisticasPartido = realizarConsulta("partido_estadisticas_$idPartido", "fixtures/statistics?fixture=$idPartido", 1800); 
            
            if (!empty($estadisticasPartido)) {

                $tablaEstadisticas = $partido->pintarEstadisticasPartido($estadisticasPartido);
                
            } else {

                $tablaEstadisticas = "<p class='parrafo_informacion'>No se encontraron estadísticas</p>";
            }
            
            $nombreEquipoLocal = $partido->__get("nombreEquipoLocal");
            $nombreEquipoVisitante = $partido->__get("nombreEquipoVisitante");
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partido_estadisticas.php';
    include '../view/templates/footer.php';