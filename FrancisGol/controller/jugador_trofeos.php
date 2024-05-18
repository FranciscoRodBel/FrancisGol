<?php
    require_once "../model/Usuario.php";
    require_once "../model/Jugador.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Trofeos jugador";
    $lista_css = ["competiciones.css"];

    $mensajeNoDatos = "<p class='parrafo_informacion'>No hay datos del jugador disponibles.</p>"; // Si algún dato está vacío se muestra este mensaje
    $datosJugador = "";
    $datosTrofeosJugador = $mensajeNoDatos;

    if (isset($_GET["jugador"]) && !empty($_GET["jugador"])) { // Si se envió el id del jugador...

        $idJugador = $_GET["jugador"];
        $jugador = Jugador::recogerJugador($idJugador);  // recojo el objeto del jugador
        
        if (!empty($jugador)) {

            $datosJugador = $jugador->pintarJugador(); // HTML con el logo y nombre del jugador
            $trofeosJugador = realizarConsulta("trofeos_jugador_$idJugador", "trophies?player=$idJugador", 86400); // Se recogen todos los trofeos del jugador
            
            if (!empty($trofeosJugador)) {

                $datosTrofeosJugador = $jugador->pintarTrofeosJugador($trofeosJugador); // Genera la tabla HTML con los trofeos
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/jugador_trofeos.php';
    include '../view/templates/footer.php';