<?php

function pintarTrofeosJugador($trofeosJugador) {
    
    $tablaTrofeos ="<table class='tabla_datos tabla_trofeos'>
    <thead><tr><th colspan='3'>Trofeos</th></tr>
    <tr><td>Competición</td><td>Tipo</td><td>Temporada</td></tr></thead><tbody>";

    foreach ($trofeosJugador->response as $trofeo) {

        if ($trofeo->place == "Winner") {
            $tablaTrofeos .= "<tr>
                <td>". $trofeo->league ."</td>
                <td>". $trofeo->country ."</td>
                <td>". $trofeo->season ."</td>
            </tr>";
        }

    }

    $tablaTrofeos .= "</tbody></table>";

    return $tablaTrofeos;
}