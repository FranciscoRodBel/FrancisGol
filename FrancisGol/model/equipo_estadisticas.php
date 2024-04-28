<?php

function generarOpcionesCompeticiones($equipoCompeticiones) {
    
    $opcionesCompeticiones = "";

    foreach ($equipoCompeticiones as $competicion) {
        
        $opcionesCompeticiones .= "<option value='{$competicion->id}'>{$competicion->nombre}</option>";
    }

    return $opcionesCompeticiones;
}


function generarOpcionesAnios($equipoCompeticiones) {


    foreach ($equipoCompeticiones as $competicion) {

        $opcionesAnios = "";

        foreach ($competicion->anios as $key => $anio) {
            
            if (count($competicion->anios) == $key+1) {
                

                $opcionesAnios .= "<option value='{$anio}' selected>{$anio}</option>";
            } else {

                $opcionesAnios .= "<option value='{$anio}'>{$anio}</option>";
            }
        }

        $arrayOpcionesAnios[$competicion->id] = $opcionesAnios;
    }

    return $arrayOpcionesAnios;
}

function pintarEstadisticasEquipo($equipoEstadisticas) {

    $tablaEstadisticas = pintarTablaEstadisticas($equipoEstadisticas);
    $tablaEstadisticas .= pintarTablaGoles($equipoEstadisticas);
    $tablaEstadisticas .= pintarTablaRachas($equipoEstadisticas);

    return $tablaEstadisticas;
}

function pintarTablaEstadisticas($equipoEstadisticas) {

    $tipoEstadisticaFixtures = array(
        "Partidos",
        "Victorias",
        "Empates",
        "Derrotas",
    );

    $tablaEstadisticas = "<table class='tabla_datos estadisticas_equipo'>";
    $tablaEstadisticas .= "<thead><tr><th rowspan='2'></th><th colspan='3'>Estadísticas</th></tr>";
    $tablaEstadisticas .= "<tr><td>Totales</td><td>Local</td><td>Visitante</td></tr></thead>";
    $tablaEstadisticas .= "<tbody>";

    $contador = 0;
    foreach ($equipoEstadisticas->response->fixtures as $key => $estadistica) {
        $tablaEstadisticas .= "
            <tr>
                <td class='tipo_estadistica'>".$tipoEstadisticaFixtures[$contador++]."</td>
                <td>". $estadistica->total ."</td>
                <td>". $estadistica->home ."</td>
                <td>". $estadistica->away ."</td>
            </tr>";
    }

    return $tablaEstadisticas;
}

function pintarTablaGoles($equipoEstadisticas) {

    $tablaEstadisticas = "";
    $tipoEstadisticaGoles = array(
        "Goles",
        "Promedio G/P",
    );

    $contador = 0;
    foreach ($equipoEstadisticas->response->goals->for as $tipoEstadistica => $estadistica) {

        if ($tipoEstadistica == "minute") {

            $tablaEstadisticas .= "</tbody></table>";
            $tablaEstadisticas .= "<table class='tabla_datos estadisticas_equipo_goles'>";
            $tablaEstadisticas .= "<thead><tr><th colspan='3'>Goles por minutos</th></tr>";
            $tablaEstadisticas .= "<tr><td>Minuto</td><td>Goles</td><td>Porcentaje</td></tr></thead>";
            $tablaEstadisticas .= "<tbody>";

            foreach ($estadistica as $minutos => $datosMinutos) {

                $tablaEstadisticas .= "
                <tr>
                    <td>". $minutos ."</td>
                    <td>". $datosMinutos->total ."</td>
                    <td>". $datosMinutos->percentage ."</td>
                </tr>";
            }

        } else {

            $tablaEstadisticas .= "
            <tr>
                <td>".$tipoEstadisticaGoles[$contador++]."</td>
                <td>". $estadistica->total ."</td>
                <td>". $estadistica->home ."</td>
                <td>". $estadistica->away ."</td>
            </tr>";
        }
    }

    $tablaEstadisticas .= "</tbody></table>";
    return $tablaEstadisticas;
}

function pintarTablaRachas($equipoEstadisticas) {
    
    $tipoEstadisticaRachas = array(
        "Victorias",
        "Empates",
        "Derrotas",
        "Mejor Victoria local",
        "Mejor Victoria visitante",
        "Peor Derrota local",
        "Peor Derrota visitante",
        "Máximo de goles marcados de local",
        "Máximo de goles marcados de Visitante",
        "Máximo de goles recibidos de local",
        "Máximo de goles recibidos de Visitante",
        "Porterías a 0 de local",
        "Porterías a 0 de visitante",
        "Porterías a 0 de total",
        "Sin marcar de local",
        "Sin marcar de visitante",
        "Sin marcar de total",
    );

    $tablaEstadisticas = "<table class='tabla_datos estadisticas_equipo_datos'>";
    $tablaEstadisticas .= "<thead><tr><th colspan='3'>Datos</th></tr>";
    $tablaEstadisticas .= "<tbody>";

    $contador = 0;
    foreach ($equipoEstadisticas->response->biggest as $estadisticas) {

        foreach ($estadisticas as $tipoEstadistica2 => $estadistica) {

            if ($tipoEstadistica2 == "for" || $tipoEstadistica2 == "against") {
            
                foreach ($estadistica as $datoEstadistica) {

                    $tablaEstadisticas .= "
                    <tr>
                        <td>".$tipoEstadisticaRachas[$contador++]."</td>
                        <td>". $datoEstadistica ."</td>
                    </tr>";
        
                }

            } else {
                $tablaEstadisticas .= "
                <tr>
                    <td>".$tipoEstadisticaRachas[$contador++]."</td>
                    <td>". $estadistica ."</td>
                </tr>";
    
            }
        }
    }

    foreach ($equipoEstadisticas->response->clean_sheet as $estadistica) {

        $tablaEstadisticas .= "
        <tr>
            <td>".$tipoEstadisticaRachas[$contador++]."</td>
            <td>". $estadistica ."</td>
        </tr>";
    }

    foreach ($equipoEstadisticas->response->failed_to_score as $estadistica) {

        $tablaEstadisticas .= "
        <tr>
            <td>".$tipoEstadisticaRachas[$contador++]."</td>
            <td>". $estadistica ."</td>
        </tr>";
    }

    $tablaEstadisticas .= "</tbody></table>";
    return $tablaEstadisticas;
}
