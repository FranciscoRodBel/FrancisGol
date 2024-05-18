<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    $jornadas = "";
    $opcionesJornadas = "";

    if (isset($_GET["competicion"]) && isset($_GET["anio"]) && !empty($_GET["competicion"]) && !empty($_GET["anio"])) {

        $anioActual = $_GET["anio"];
        $idCompeticion = $_GET["competicion"];
        $competicion = Competicion::recogerCompeticion($idCompeticion); // Se recoge el objeto de la competición

        if (!empty($competicion)) {

            $jornadasCompeticion = realizarConsulta("competicion_jornadas_".$idCompeticion."_".$anioActual, "fixtures?league=$idCompeticion&season=$anioActual", 86400); // Se recogen las jornadas del partido
            
            if (!empty($jornadasCompeticion)) {
            
                $datosJornadas = $competicion->generarJornadas($jornadasCompeticion); // Se generan las jornadas y los options de las jornadas
                $opcionesJornadas = $datosJornadas[0];
                $jornadas = $datosJornadas[1];

            }
        }
    }

    echo json_encode([$jornadas, $opcionesJornadas]);