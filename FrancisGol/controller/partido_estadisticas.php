<?php
    require_once "../model/Usuario.php";
    require_once "../model/Partido.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Estadísticas partido";
    $lista_css = ["partidos_liga.css"];

    $nombreEquipoLocal = "Equipo";
    $nombreEquipoVisitante = "Equipo";
    $datosPartido = "";
    $tablaEstadisticas = "<p class='parrafo_informacion'>Partido no encontrado.</p>"; // Si algún dato está vacío se muestra este mensaje

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) { // Si se envió el id del partido...

        $idPartido = $_GET["partido"];
        $partido = Partido::recogerPartido($idPartido); // recojo el objeto del partido
        
        if (!empty($partido)) {

            $datosPartido = $partido->pintarPartido(); // HTML con el logo y nombre del de los equipos y el resultado
            $estadisticasPartido = realizarConsulta("partido_estadisticas_$idPartido", "fixtures/statistics?fixture=$idPartido", 1800); // Se recogen las estadísticas del partido cada media hora
            
            if (!empty($estadisticasPartido)) {

                $tablaEstadisticas = $partido->pintarEstadisticasPartido($estadisticasPartido); // Genera el HTML con las estadísticas de ambos equipos
                
            } else {

                $tablaEstadisticas = "<p class='parrafo_informacion'>No se encontraron estadísticas.</p>";
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