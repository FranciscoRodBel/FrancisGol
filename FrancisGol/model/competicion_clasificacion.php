<?php
function recogerClasificacion($idCompeticion) {

    $archivo = "../view/assets/json/competicion_clasificacion_$idCompeticion.json"; // Nombre del archivo

    // Verifica si existe un archivo y si fue modificado en el último día
    if (file_exists($archivo) && (time() - filemtime($archivo) < 86400)) {

        $datos = file_get_contents($archivo);
        $resultado = json_decode($datos);

    } else {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://v3.football.api-sports.io/standings?league='.$idCompeticion.'&season=2023',
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