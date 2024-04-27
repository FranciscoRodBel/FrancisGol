<?php

function generarFechasPartidos() {
    
    $fecha_actual = date("Y-m-d");

    $fechas = [];

    for ($i=-4; $i < 5; $i++) { 

        array_push($fechas, date("Y-m-d", strtotime("$i day", strtotime($fecha_actual))));

    }

    $fechas_partidos = "<a href='../controller/partidos.php?fecha=".$fechas[0]."'>".substr($fechas[0],8)."</a><hr>";
    $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[1]."'>".substr($fechas[1],8)."</a><hr>";
    $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[2]."'>".substr($fechas[2],8)."</a><hr>";
    $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[3]."'>Ayer</a><hr>";
    $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[4]."'>Hoy</a><hr>";
    $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[5]."'>Mañana</a><hr>";
    $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[6]."'>".substr($fechas[6],8)."</a><hr>";
    $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[7]."'>".substr($fechas[7],8)."</a><hr>";
    $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[8]."'>".substr($fechas[8],8)."</a>";

    return $fechas_partidos;

}

function pintarPartidos($partidos) {
    
    $todosLosPartidos = "";

    foreach ($partidos->response as $partido) {

        // echo "<pre>";
        // print_r($partido);
        // echo "</pre>";
        $hora_partido = strtotime($partido->fixture->date);
        // $hora_partido = strtotime('+2 hours', $hora_partido);
        $hora_partido = date('H:i', $hora_partido);
        
        $partidosDeUnaLiga = '
            <div class="enfrentamiento_equipos">
                <a href="../controller/partido_resumen.php?partido='.$partido->fixture->id.'">
                    <div class="equipo_local">
                        <img src="'.$partido->teams->home->logo.'" alt="Logo">
                        <span>'.$partido->teams->home->name.'</span>
                    </div>
                    <div class="resultado_hora">
                        <p>VS</p>';
                        if (date('H:i') > $hora_partido) {

                            $partidosDeUnaLiga .= '<p>'.$hora_partido.'</p>';
                        } else {

                            $partidosDeUnaLiga .= '<p>'.$partido->goals->home.' - '.$partido->goals->away.'</p>';
                        }

        $partidosDeUnaLiga .= '</div>
                    <div class="equipo_visitante">
                        <img src="'.$partido->teams->away->logo.'" alt="Logo">
                        <span>'.$partido->teams->away->name.'</span>
                    </div>
                </a>
            </div>
            <hr class="separacion_partidos">';

        $idLigaActual = $partido->league->id;
        $datosLiga[$idLigaActual] = [$partido->league->logo, $partido->league->name];
        $partidosPorLiga[$idLigaActual][] = $partidosDeUnaLiga;

    }
    
    foreach ($partidosPorLiga as $idLiga => $partidosLiga) {

        $todosLosPartidos .= '
                <section class="seccion_negra">
                    <div class="competicion_equipo">
                        <a href="../controller/competicion.php?competicion='.$idLiga.'">
                            <img src="'.$datosLiga[$idLiga][0].'" alt="Logo">
                            <span>'.$datosLiga[$idLiga][1].'</span>
                        </a>
                        <i class="fa-solid fa-star icono_estrella"></i>
                    </div>
                    <hr>';

        foreach ($partidosLiga as $partidoLiga) {
            $todosLosPartidos .= $partidoLiga;
        }

        $todosLosPartidos .= "</section>";

    }

    return $todosLosPartidos;
}