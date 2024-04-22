<?php
    function seleccionarPais() {

        $archivo = "../view/assets/json/paises.json"; // Nombre del archivo

        // Verificar si existe un archivo y si fue modificado en el último día
        if (file_exists($archivo) && (time() - filemtime($archivo) < 86400)) {

            $datos = file_get_contents($archivo);
            $resultado = json_decode($datos);
    
        } else {

            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://v3.football.api-sports.io/countries',
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

    function crearOpcionesPaises($paises) {

        $opciones = "";
        foreach ($paises->response as $pais) {

            if ($pais->name == "Spain") {

                $opciones .= "<option value='".$pais->code."' selected>".$pais->name."</option>";
            } else {
                $opciones .= "<option value='".$pais->code."'>".$pais->name."</option>";
            }
        }

        return $opciones;
    }