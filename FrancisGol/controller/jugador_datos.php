<?php
    session_start();
    require_once "../model/Jugador.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Equipo estadísticas";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["jugador"]) && !empty($_GET["jugador"])) {

        $idJugador = $_GET["jugador"];
        $jugador = Jugador::recogerJugador($idJugador);
        $datosJugador = $jugador->pintarJugador();
        
        $tablaDatosJugador = $jugador->pintarDatosJugador();

    } else {
        $tablaDatosJugador = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/jugador_datos.php';
    include '../view/templates/footer.php';