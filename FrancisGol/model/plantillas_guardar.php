<?php

function comprobarDatosJugadores($formacion, $posicionesJugadores, $datosPlantilla) {
    $posiciones = generarClasesPosicionJugador($formacion);

    foreach (json_decode($datosPlantilla)->response[0]->players as $numeroJugador => $jugador) {

        if($numeroJugador >= 11 && $numeroJugador < 23) {
            
            array_push($posiciones, "suplentes_$numeroJugador");

        } else if($numeroJugador >= 23) {

            array_push($posiciones, "no_convocado_$numeroJugador");
        }

        if (!array_key_exists($jugador->id, $posicionesJugadores)) {
            return false;
        }
    }

    foreach ($posicionesJugadores as $posicionesJugador) {
        
        if (!in_array($posicionesJugador, $posiciones)) {
            return false;
            
        } else {
            unset($posiciones[array_search($posicionesJugador,$posiciones)]);
        }

    }

    return true;
}

function guardarDatosJugadores($posicionesJugadores, $titulo, $formacion, $datosPlantilla) {
    
    $usuario = unserialize($_SESSION['usuario']);
    $usuario->id;

}