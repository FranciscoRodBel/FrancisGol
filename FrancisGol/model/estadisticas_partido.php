<?php

function recogerEstadisticasPartido($idPartido) {

    $archivo = "../view/assets/json/estadisticas_partido".$idPartido.".json"; // Nombre del archivo

    // Verifica si existe un archivo y si fue modificado en el último día
    if (file_exists($archivo) && (time() - filemtime($archivo) < 86400)) {

        $datos = file_get_contents($archivo);
        $resultado = json_decode($datos);

    } else {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://v3.football.api-sports.io/fixtures/statistics?fixture='.$idPartido,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'GET',
        CURLOPT_HTTPHEADER => array(
            'x-rapidapi-key: be6e260f0828d5854c973280d67305cd',
            'x-rapidapi-host: v3.football.api-sports.io'
        ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);

        file_put_contents($archivo, $response);

        $resultado = json_decode($response);

        }

    return $resultado;

}

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


