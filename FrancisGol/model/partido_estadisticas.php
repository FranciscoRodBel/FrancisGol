<?php

function pintarEstadisticasPartido($estadisticasPartido) {
 
    $tablaEstadisticas = "";
    $tipoEstadistica = array("Tiros a puerta", "Tiros a fuera", "Tiros totales", "Tiros bloqueados", "Tiros dentro del área", "Tiros fuera del área", "Faltas cometidas", "Saques de esquina", "Fueras de juego", "Posesión del balón", "Tarjetas amarillas", "Tarjetas rojas", "Tiros parados", "Pases totales", "Pases efectivos", "% de pases", "Goles esperados");

    foreach ($estadisticasPartido->response as $key => $equipo) {
        // echo "<h3>Estadísticas ".$equipo->team->name." </h3>";
        // echo "Id {$equipo->team->name}: {$equipo->team->id}<br>";
        // echo "<img src=".$equipo->team->logo." alt='logo'><br>";
        // echo "<h4>Estadísticas</h4>";

        $tablaEstadisticas .= " <table class='tabla_datos'>
        <thead>
            <tr>
                <th colspan='2'>".$equipo->team->name."</th>
            </tr>
        </thead>
        <tbody>";

        foreach ($equipo->statistics as $key => $estadistica) {
            // echo $estadistica->type.": {$estadistica->value} <br>";

            $tablaEstadisticas .= "
                    <tr>
                        <td>".$tipoEstadistica[$key]."</td>
                        <td>". $estadistica->value ."</td>
                    </tr>";

        }

        $tablaEstadisticas .= "</tbody>
        </table>";
    }

    return $tablaEstadisticas;
}


