<?php

function realizarConsulta(string $nombreJson, string $rutaApi, int $tiempoGuardado): string|object {
    
    $archivo = "../view/assets/json/$nombreJson.json"; // Nombre del archivo

    // Verifica si existe un archivo y si fue modificado en el último día
    if (file_exists($archivo) && (time() - filemtime($archivo) < $tiempoGuardado)) { // Si existe y le falta tiempo por renovar el JSON...

        $datos = file_get_contents($archivo);  // Recoge el JSON 
        $resultado = json_decode($datos);

        if ($resultado->results == 0) {
            return "";
        }

    } else { // Si no existe o el tiempo de validez del JSON terminó...

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://v3.football.api-sports.io/$rutaApi",
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

        $response = curl_exec($curl); // Recojo los datos 
        curl_close($curl);

        $resultado = json_decode($response);

        if (!empty($resultado)) {

            file_put_contents($archivo, $response); // guardo los datos en un JSON

            if ($resultado->results == 0) return "";

        } else {

            return "";
        }
    }

    return $resultado; // Devuelvo los datos si están bien
}


function realizarConsultaSinJson(string $rutaApi) : string|object {
    
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://v3.football.api-sports.io/$rutaApi",
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

    $response = curl_exec($curl); // Recojo los datos
    curl_close($curl);

    $resultado = json_decode($response);

    if (!empty($resultado)) {

        if ($resultado->results == 0) return "";

    } else {
        
        return "";
    }

    return $resultado; // Los devuelvo si están bien
}