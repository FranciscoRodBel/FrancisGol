<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Jugador.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Equipo estadísticas";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["jugador"]) && !empty($_GET["jugador"])) {

        $idJugador = $_GET["jugador"];
        $jugador = Jugador::recogerJugador($idJugador);
        
        if (empty($jugador)) {

            $tablaDatosJugador = "<p class='parrafo_informacion'>No hay datos del jugador disponibles</p>";
            $datosJugador = "";
            
        } else {

            $temporadasDisponibles = realizarConsulta("temporadas_disponibles_jugador", "players/seasons", 86400);
            $optionsAniosDisponibles = Competicion::generarOptionsTemporadas($temporadasDisponibles);

            $datosJugador = $jugador->pintarJugador();
            $anioActual = date("Y") - 1;
            $tablaDatosJugador = $jugador->pintarDatosJugador($anioActual);
        }


    } else {
        $tablaDatosJugador = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/jugador_datos.php';
    include '../view/templates/footer.php';