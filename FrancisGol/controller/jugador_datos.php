<?php
    require_once "../model/Usuario.php";
    require_once "../model/Jugador.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Datos jugador";
    $lista_css = ["competiciones.css"];

    $tablaDatosJugador = "<p class='parrafo_informacion'>No hay datos del jugador disponibles.</p>"; // Si algún dato está vacío se muestra este mensaje
    $datosJugador = "";

    if (isset($_GET["jugador"]) && !empty($_GET["jugador"])) { // Si se envió el id del jugador...

        $idJugador = $_GET["jugador"];
        $jugador = Jugador::recogerJugador($idJugador); // recojo el objeto del jugador
        
        if (!empty($jugador)) {

            $temporadasDisponibles = realizarConsulta("temporadas_disponibles_jugador_$idJugador", "players/seasons", 86400); // Recojo las temporadas que están disponibles para todos los jugadores
            
            if (!empty($temporadasDisponibles)) {

                $optionsAniosDisponibles = Competicion::generarOptionsTemporadas($temporadasDisponibles);
                $datosJugador = $jugador->pintarJugador(); // HTML con el logo y nombre del jugador
                $anioActual = date("Y") - 1;
                $tablaDatosJugador = $jugador->pintarDatosJugador($anioActual); // Genera el HTML con los datos y estadísticas del jugador
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/jugador_datos.php';
    include '../view/templates/footer.php';

