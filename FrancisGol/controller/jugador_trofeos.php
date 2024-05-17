<?php
    require_once "../model/Usuario.php";
    require_once "../model/Jugador.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Trofeos jugador";
    $lista_css = ["competiciones.css"];

    $mensajeNoDatos = "<p class='parrafo_informacion'>No hay datos del jugador disponibles</p>";
    $datosJugador = "";
    $datosTrofeosJugador = $mensajeNoDatos;

    if (isset($_GET["jugador"]) && !empty($_GET["jugador"])) {

        $idJugador = $_GET["jugador"];
        $jugador = Jugador::recogerJugador($idJugador);
        
        if (!empty($jugador)) {

            $datosJugador = $jugador->pintarJugador();
            $trofeosJugador = realizarConsulta("trofeos_jugador_$idJugador", "trophies?player=$idJugador", 86400); 
            
            if (!empty($trofeosJugador)) {

                $datosTrofeosJugador = $jugador->pintarTrofeosJugador($trofeosJugador);
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/jugador_trofeos.php';
    include '../view/templates/footer.php';