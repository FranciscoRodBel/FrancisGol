<?php
function generarPlantilla($equipoPlantilla) {

    $jugadoresPlantilla = "<div><div>Foto</div>";
    $jugadoresPlantilla .= "<div>Nombre</div>";
    $jugadoresPlantilla .= "<div>Edad</div>";
    $jugadoresPlantilla .= "<div>Dorsal</div>";
    $jugadoresPlantilla .= "<div>Posicion</div>";
    $jugadoresPlantilla .= "</div>";

    foreach ($equipoPlantilla->response[0]->players as $key => $jugador) {

        $posicion = match ($jugador->position) {
           "Goalkeeper" => "Portero",
           "Defender" => "Defensa",
           "Midfielder" => "Mediocentro",
           "Attacker" => "Delantero",
           default => "Desconocida"
        };


        $jugadoresPlantilla .= "<a href='#'><div>";
        $jugadoresPlantilla .= "<img src=".$jugador->photo." alt='logo competición'>";
        $jugadoresPlantilla .= "<div>".$jugador->name."</div>";
        $jugadoresPlantilla .= "<div>".$jugador->age."</div>";
        $jugadoresPlantilla .= "<div>".$jugador->number."</div>";
        $jugadoresPlantilla .= "<div>".$posicion."</div>";
        $jugadoresPlantilla .= "</div></a>";
        // id jugador: $jugador->id
        // $jugadoresPlantilla .= "<a href='#'><tr>";
        //     $jugadoresPlantilla .= "<td><img src=".$jugador->photo." alt='logo competición'></td>";
        //     $jugadoresPlantilla .= "<td>".$jugador->name."</td>";
        //     $jugadoresPlantilla .= "<td>".$jugador->age."</td>";
        //     $jugadoresPlantilla .= "<td>".$jugador->number."</td>";
        //     $jugadoresPlantilla .= "<td>".$posicion."</td>";
        // $jugadoresPlantilla .= "</tr></a>";
    }
    $jugadoresPlantilla .= "</tbody></table>";
    return $jugadoresPlantilla;
}