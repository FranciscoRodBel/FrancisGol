<?php
    require_once "../model/Usuario.php";
    require_once "../model/Partido.php";
    require_once "../model/Jugador.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Alineaciones partido";
    $lista_css = ["partidos_liga.css", "alineaciones.css"];

    $nombreEquipoLocal = "Equipo";
    $nombreEquipoVisitante = "Equipo";
    $datosPartido = "";
    $alineacionesPartido = "<p class='parrafo_informacion'>Partido no encontrado.</p>"; // Si algún dato está vacío se muestra este mensaje

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) { // Si se envió el id del partido...

        $idPartido = $_GET["partido"];
        $partido = Partido::recogerPartido($idPartido); // recojo el objeto del partido
        
        if (!empty($partido)) {

            $datosPartido = $partido->pintarPartido(); // HTML con el logo y nombre del de los equipos y el resultado
            $alineacionesPartido = realizarConsulta("partido_alineaciones_$idPartido", "fixtures/lineups?fixture=$idPartido", 1800); // Se recogen las alineaciones del partido cada media hora
            
            if (!empty($alineacionesPartido)) {

                $alineacionesPartido = $partido->pintarAlineacionesPartido($alineacionesPartido); // Genera el HTML con las alienaciones de ambos equipos

            } else {
                
                $alineacionesPartido = "<p class='parrafo_informacion'>No se encontraron alineaciones.</p>";
            }
            
            $nombreEquipoLocal = $partido->__get("nombreEquipoLocal");
            $nombreEquipoVisitante = $partido->__get("nombreEquipoVisitante");
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partido_alineaciones.php';
    include '../view/templates/footer.php';