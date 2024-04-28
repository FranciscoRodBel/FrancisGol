<?php
    require_once "../model/Jugador.php";
    require_once "../model/jugador_datos.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Equipo estadísticas";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["jugador"]) && !empty($_GET["jugador"])) {

        $idJugador = $_GET["jugador"];
        $datosJugador = Jugador::recogerJugador($idJugador);
        $tablaDatosJugador = pintarDatosJugador($datosJugador[1]);
        $datosJugador = $datosJugador[0];

    } else {
        $tablaDatosJugador = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/jugador_datos.php';
    include '../view/templates/footer.php';