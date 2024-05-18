<?php
    require_once "../model/Usuario.php";
    require_once "../model/Partido.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Resumen partido";
    $lista_css = ["partidos_liga.css"];

    $datosPartido = "";
    $resumenPartido = "<p class='parrafo_informacion'>Partido no encontrado.</p>"; // Si algún dato está vacío se muestra este mensaje

    if (isset($_GET["partido"]) && !empty($_GET["partido"])) { // Si se envió el id del partido...

        $idPartido = $_GET["partido"];
        $partido = Partido::recogerPartido($idPartido); // recojo el objeto del partido
        
        if (!empty($partido)) {

            $datosPartido = $partido->pintarPartido(); // HTML con el logo y nombre del de los equipos y el resultado
            $eventosPartido = realizarConsulta("partido_resumen_$idPartido", "fixtures/events?fixture=$idPartido", 1800); // Se recogen los eventos del partido cada media hora 
            
            if (!empty($eventosPartido)) {

                $resumenPartido = $partido->pintarResumenPartido($eventosPartido); // Genera el HTML con los eventos de ambos equipos
                
            } else {

                $resumenPartido = "<p class='parrafo_informacion'>No hay eventos disponibles.</p>";
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partido_resumen.php';
    include '../view/templates/footer.php';