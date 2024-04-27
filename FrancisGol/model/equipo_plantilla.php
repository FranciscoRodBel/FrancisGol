<?php
function generarPlantilla($equipoPlantilla) {

    $jugadoresPlantilla = "
    <table><thead><tr>
        <td></td>
        <td>Nombre</td>
        <td>Edad</td>
        <td>Dorsal</td>
        <td>Posición</td>
    </tr></thead><tbody>";

    foreach ($equipoPlantilla->response[0]->players as $key => $jugador) {

        $posicion = match ($jugador->position) {
           "Goalkeeper" => "Portero",
           "Defender" => "Defensa",
           "Midfielder" => "Mediocentro",
           "Attacker" => "Delantero",
           default => "Desconocida"
        };
        // id jugador: $jugador->id
        $jugadoresPlantilla .= "<a href=''><tr>";
            $jugadoresPlantilla .= "<td><img src=".$jugador->photo." alt='logo competición'></td>";
            $jugadoresPlantilla .= "<td>".$jugador->name."</td>";
            $jugadoresPlantilla .= "<td>".$jugador->age."</td>";
            $jugadoresPlantilla .= "<td>".$jugador->number."</td>";
            $jugadoresPlantilla .= "<td>".$posicion."</td>";
        $jugadoresPlantilla .= "</tr></a>";
    }
    $jugadoresPlantilla .= "</tbody></table>";
    return $jugadoresPlantilla;
}