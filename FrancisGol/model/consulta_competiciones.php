<?php

function seleccionarCompeticion() {

    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://v3.football.api-sports.io/leagues',
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

    $resultado = json_decode($response);

    return $resultado;
}