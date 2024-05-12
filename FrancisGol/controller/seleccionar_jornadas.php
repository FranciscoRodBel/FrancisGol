<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_GET["competicion"]) && isset($_GET["anio"]) && !empty($_GET["competicion"]) && !empty($_GET["anio"])) {

        $anioActual = $_GET["anio"];
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion);

        if (!empty($competicion)) {

            $jornadasCompeticion = realizarConsulta("competicion_jornadas_".$idCompeticion."_".$anioActual, "fixtures?league=$idCompeticion&season=$anioActual", 86400);
            $datosJornadas = $competicion->generarJornadas($jornadasCompeticion);
            $opcionesJornadas = $datosJornadas[0];
            $jornadas = $datosJornadas[1];

        } else {

            $jornadas = "";
            $opcionesJornadas = "";
        }

    } else {
    
        $jornadas = "";
        $opcionesJornadas = "";
    }

    echo json_encode([$jornadas, $opcionesJornadas]);