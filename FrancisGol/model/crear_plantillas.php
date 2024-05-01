<?php

function generarSelectFormaciones() {
    $formaciones = array("3-1-4-2", "3-4-1-2", "3-4-2-1", "3-4-3", "3-5-1-1", "3-5-2", "3-6-1", "4-1-2-1-2", "4-1-3-1-1", "4-1-3-2", "4-1-4-1", "4-2-1-3", "4-2-2-2", "4-2-3-1", "4-3-1-2", "4-3-2-1", "4-3-3", "4-4-1-1", "4-4-2", "4-5-1", "5-3-2", "5-4-1");
    
    $optionsFormaciones = "";
    foreach ($formaciones as $formacion) {

        if ($formacion == "4-3-3") {

            $optionsFormaciones .= "<option value='$formacion' selected>$formacion</option>";
        } else {

            $optionsFormaciones .= "<option value='$formacion'>$formacion</option>";
        }

    }
    return $optionsFormaciones;
}

function generarPlantilla($equipoPlantilla) {

    $clasesJugador = generarClasesPosicionJugador("4-3-3");

    $alineacionPrincipal = "<div class='alineacion'><div class='formacion_equipo formacion_4-3-3'>"; 
    
    
    foreach ($equipoPlantilla->response[0]->players as $numeroJugador => $jugador) {

        // $jugador->id;
        if ($numeroJugador < 11) {
            
            $alineacionPrincipal .= 
            "<div class='".$clasesJugador[$numeroJugador]."' draggable='true'>
                <img src='{$jugador->photo}' alt='foto'>
                <p>{$jugador->name}</p>
            </div>";

        } else if($numeroJugador < 23) {

            $alineacionPrincipal .= $numeroJugador == 11 ? "</div></div><p class='titulo_seccion'>Suplentes</p><section class='seccion_negra jugadores_suplentes'>" : "";
            
            $alineacionPrincipal .= "<div class='suplentes_".$numeroJugador."' draggable='true'>
                                        <img src='{$jugador->photo}' alt='foto'>
                                        <p>{$jugador->name}</p>
                                    </div>";
        } else {

            $alineacionPrincipal .= $numeroJugador == 23 ? "</section><p class='titulo_seccion'>No convocados</p><section class='seccion_negra jugadores_suplentes'>" : "";
            
            $alineacionPrincipal .= "<div class='no_convocado_".$numeroJugador."' draggable='true'>
                                        <img src='{$jugador->photo}' alt='foto'>
                                        <p>{$jugador->name}</p>
                                    </div>";
        }
        
    }
    $alineacionPrincipal .= "</section>";
    return $alineacionPrincipal;
}

function generarClasesPosicionJugador($formacion) {
    
    $formacion = explode("-",$formacion);

    $clasesGeneradas = ["jugador_1_1"];

    foreach ($formacion as $clave => $numeroJugadoresPosicion) {
        
        for ($i=1; $i <= $numeroJugadoresPosicion; $i++) { 
            
            array_push($clasesGeneradas, "jugador_". $clave+2 ."_".$i);
        }
    }

    return $clasesGeneradas;
}