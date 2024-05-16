<?php
    require_once "../model/Usuario.php";
    require_once "../model/Partido.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Resumen partido";
    $lista_css = ["partidos_liga.css"];
    
    if (isset($_GET["partido"]) && !empty($_GET["partido"])) {
    
        $idPartido = $_GET["partido"];
        $partido = Partido::recogerPartido($idPartido);
        
        if (!empty($partido)) {
            
            $datosPartido = $partido->pintarPartido();
        
            $eventosPartido = realizarConsulta("partido_resumen_$idPartido", "fixtures/events?fixture=$idPartido", 1800); 
    
            $resumenPartido = $partido->pintarResumenPartido($eventosPartido);

        } else {

            $datosPartido = "";
            $resumenPartido = "<p class='parrafo_informacion'>Partido no encontrado</p>";
        }

    } else {
      
        $datosPartido = "";
        $resumenPartido = "<p class='parrafo_informacion'>Partido no encontrado</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partido_resumen.php';
    include '../view/templates/footer.php';