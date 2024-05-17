<?php
    require_once "../model/Usuario.php";
    require_once "../model/Partido.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Partidos";
    $lista_css = ["partidos_liga.css"];

    $fechas_partidos = Partido::generarFechasPartidos();
    
    $fecha = isset($_GET["fecha"]) && !empty($_GET["fecha"]) ? $_GET["fecha"] : date("Y-m-d");
    $formato = 'Y-m-d';
    $objetoFecha = DateTime::createFromFormat($formato, $fecha);

    if ($objetoFecha && $objetoFecha->format($formato) === $fecha) {

        $partidos = realizarConsulta("partidos_$fecha", "fixtures?date=$fecha", 3600); 

        if (!empty($partidos)) {

            $partidosSeleccionados = Partido::pintarPartidos($partidos);

        } else {

            $partidosSeleccionados = "<p class='parrafo_informacion'>No hay partidos disponibles</p>";
        }
        
    } else {

        $partidosSeleccionados = "<p class='parrafo_informacion'>La fecha enviada no es correcta</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partidos.php';
    include '../view/templates/footer.php';