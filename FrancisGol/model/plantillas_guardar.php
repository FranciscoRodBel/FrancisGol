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
    
    $conexion = FrancisGolBD::establecerConexion();

    $usuario = unserialize($_SESSION['usuario']);
    $idUsuario = $usuario->id;
    $idEquipo = json_decode($datosPlantilla)->response[0]->team->id;
    $escudo = json_decode($datosPlantilla)->response[0]->team->logo;
    $anio = 2023;

    $consulta = $conexion->prepare("INSERT INTO plantilla (titulo, anio, formacion, idEquipo, escudo, idUsuario)  VALUES (?, ?, ?, ?, ?, ?)");
    $consulta->bind_param("sisisi", $titulo, $anio, $formacion, $idEquipo, $escudo, $idUsuario);
    $consulta->execute();
    
    $idPlantilla = mysqli_insert_id($conexion);

    foreach (json_decode($datosPlantilla)->response[0]->players as $jugador) {
        
        $idJugador = $jugador->id;
        $nombreJugador = $jugador->name;
        $fotoJugador = $jugador->photo;
        $posicion = $posicionesJugadores[$idJugador];
    
        $consulta = $conexion->prepare("INSERT INTO jugador (idJugador, nombre, foto)  VALUES (?, ?, ?)");
    
        try {
            $consulta->bind_param("iss", $idJugador, $nombreJugador, $fotoJugador);
            $consulta->execute();

        } catch (mysqli_sql_exception) {
            // Si el jugador ya está insertado no hace nada
        }

        $consulta = $conexion->prepare("INSERT INTO plantilla_jugador (idPlantilla,	idJugador,	posicion)  VALUES (?, ?, ?)");
        $consulta->bind_param("iis", $idPlantilla, $idJugador, $posicion);
        $consulta->execute();

    }
    return $idPlantilla;
}