
<?php
    require_once "../model/Usuario.php";
    require_once "../model/Jugador.php";
    require_once "../model/realizar_consultas.php";

    $datosJugador = "";

    if (isset($_GET["jugador"]) && isset($_GET["anio"]) && !empty($_GET["jugador"]) && !empty($_GET["anio"])) {

        $anioActual = $_GET["anio"];
        $idJugador = $_GET["jugador"];
        $jugador = Jugador::recogerJugador($idJugador);

        if (!empty($jugador)) {

            $datosJugador = $jugador->pintarDatosJugador($anioActual);

            if (empty($datosJugador)) {
                
                $datosJugador = "<p class='parrafo_informacion'>Los datos del jugador no están disponibles.</p>";
            }
        }
    }

    echo $datosJugador;