<?php

function recogerAlineacionesPartido($idPartido) {

    $archivo = "../view/assets/json/alineaciones_partido".$idPartido.".json"; // Nombre del archivo

    // Verifica si existe un archivo y si fue modificado en el último día
    if (file_exists($archivo) && (time() - filemtime($archivo) < 86400)) {

        $datos = file_get_contents($archivo);
        $resultado = json_decode($datos);

    } else {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://v3.football.api-sports.io/fixtures/lineups?fixture='.$idPartido,
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

function pintarAlineacionesPartido($alineacionesPartido) {
    print_r($alineacionesPartido);

    echo "<h3>Alineaciones del partido: </h3>";

    foreach ($alineacionesPartido->response as $alineacion) {

        echo "<h3>Alineación de ". $alineacion->team->name ."</h3>";
        echo "<p>Formación: ". $alineacion->formation ."</p>";
        echo "<h4>Titulares</h4>";
        echo "<ul>";

        foreach ($alineacion->startXI as $jugador) {
            echo "<li>{$jugador->player->name} ({$jugador->player->pos}) - {$jugador->player->grid}</li>";
        }

        echo "</ul>";

        if (!empty($alineacion->substitutes)) {

            echo "<h4>Suplentes</h4>";
            echo "<ul>";

            foreach ($alineacion->substitutes as $suplente) {
                echo "<li>{$suplente->player->name} ({$suplente->player->pos})</li>";
            }

            echo "</ul>";
        }
    }
}