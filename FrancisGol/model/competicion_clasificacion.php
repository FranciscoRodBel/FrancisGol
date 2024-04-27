<?php

function generarClasificacion($clasificacion) {
    
    // echo "<h3>Clasificación ".$clasificacion->response[0]->league->name." año ".$clasificacion->response[0]->league->season.": </h3>";
    $tablaClasificacion = "<table><thead><tr>
        <td></td>
        <td>Club</td>
        <td>Pts</td>
        <td>Pj</td>
        <td>V</td>
        <td>E</td>
        <td>D</td>
        <td>GF</td>
        <td>GC</td>
        <td>GD</td></tr></thead><tbody>";

    foreach ($clasificacion->response[0]->league->standings[0] as $equipo) {

        $tablaClasificacion .= "<tr>
            <td><img src=".$equipo->team->logo." alt='escudo'></td>
            <td>".$equipo->team->name."</td>
            <td>".$equipo->points."</td>
            <td>".$equipo->all->played."</td>
            <td>".$equipo->all->win."</td>
            <td>".$equipo->all->draw."</td>
            <td>".$equipo->all->lose."</td>
            <td>".$equipo->all->goals->for."</td>
            <td>".$equipo->all->goals->against."</td>
            <td>".$equipo->goalsDiff."</td>
        </tr>";

    }

    $tablaClasificacion .= "</tbody></table>";

    return $tablaClasificacion;
}