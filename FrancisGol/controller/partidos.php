<?php
    require_once "../model/Usuario.php";
    require_once "../model/Partido.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Partidos";
    $lista_css = ["partidos_liga.css"];

    $fechas_partidos = Partido::generarFechasPartidos(); // Crea los días que se muestran en la parte superior de la página
    
    $fecha = isset($_GET["fecha"]) && !empty($_GET["fecha"]) ? $_GET["fecha"] : date("Y-m-d"); // Recojo la fecha, en caso de que no se envíe recojo la de hoy
    $formato = 'Y-m-d';
    $objetoFecha = DateTime::createFromFormat($formato, $fecha); // Crea un objeto que tendrá el formato de la fecha

    if ($objetoFecha && $objetoFecha->format($formato) == $fecha) { // Si la fecha tiene el formato correcto...

        $partidos = realizarConsulta("partidos_$fecha", "fixtures?date=$fecha", 1800); // Recoge los partidos cada media hora

        if (!empty($partidos)) {

            $partidosSeleccionados = Partido::pintarPartidos($partidos); // Genera el HTML con los partidos de hoy

        } else {

            $partidosSeleccionados = "<p class='parrafo_informacion'>No hay partidos disponibles.</p>";
        }
        
    } else {

        $partidosSeleccionados = "<p class='parrafo_informacion'>La fecha enviada no es correcta.</p>";
    }

    $fecha = new DateTime($fecha);
    $fecha = $fecha->format('d-m-Y');

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partidos.php';
    include '../view/templates/footer.php';