<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Partido.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Partidos";
    $lista_css = ["partidos_liga.css"];


    $fechas_partidos = Partido::generarFechasPartidos();
    
    $fecha = isset($_GET["fecha"]) && !empty($_GET["fecha"]) ? $_GET["fecha"] : date("Y-m-d");

    $partidos = realizarConsulta("partidos_$fecha", "fixtures?date=$fecha", 86400); 

    $partidosSeleccionados = Partido::pintarPartidos($partidos);
    

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/partidos.php';
    include '../view/templates/footer.php';