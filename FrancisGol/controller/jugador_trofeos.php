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

        $trofeosJugador = realizarConsulta("trofeos_jugador_$idJugador", "trophies?player=$idJugador", 86400); 
        $datosTrofeosJugador = $jugador->pintarTrofeosJugador($trofeosJugador);

    } else {
        $datosTrofeosJugador = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/jugador_trofeos.php';
    include '../view/templates/footer.php';