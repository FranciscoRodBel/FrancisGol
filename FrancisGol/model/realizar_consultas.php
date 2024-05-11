<?php

function realizarConsulta($nombreJson, $rutaApi, $tiempoGuardado) {
    
    $archivo = "../view/assets/json/$nombreJson.json"; // Nombre del archivo

    // Verifica si existe un archivo y si fue modificado en el último día
    if (file_exists($archivo) && (time() - filemtime($archivo) < $tiempoGuardado)) {

        $datos = file_get_contents($archivo);
        $resultado = json_decode($datos);

    } else {
        
        $arrayApiKeys = ["be6e260f0828d5854c973280d67305cd", "26df0569c8617e64e44a5a72cdebee09"];

        foreach ($arrayApiKeys as $apiKey) {

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
                'x-rapidapi-key: '.$apiKey,
                'x-rapidapi-host: v3.football.api-sports.io'
            ),
            ));

            $response = curl_exec($curl);
            curl_close($curl);

            $resultado = json_decode($response);

            if (!empty($resultado->errors) && $resultado->errors->requests != "You have reached the request limit for the day, Go to https://dashboard.api-football.com to upgrade your plan.") {

                file_put_contents($archivo, $response);
                return $resultado;
            }
        }
    }

    return $resultado;
}