<?php

function recogerFichajes($idEquipo) {
    
    $archivo = "../view/assets/json/fichajes_$idEquipo.json"; // Nombre del archivo

    // Verifica si existe un archivo y si fue modificado en el último día
    if (file_exists($archivo) && (time() - filemtime($archivo) < 86400)) {

        $datos = file_get_contents($archivo);
        $resultado = json_decode($datos);

    } else {

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://v3.football.api-sports.io/transfers?team='.$idEquipo,
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

function pintarFichajesEquipo($fichajesEquipo) {

    $fichajes = "";



    foreach ($fichajesEquipo->response as $key => $jugador) {

        foreach ($jugador->transfers as $key => $datoFichaje) {

            if (preg_match("/^2024/", $datoFichaje->date) || preg_match("/^2023/", $datoFichaje->date)) {
    
                // $jugador->player->id
                $fichajes .= "<div>
                    <div class='datos_fichaje'>
                        <a href=''>".$jugador->player->name."</a>
                        <hr>
                        <p>".$datoFichaje->date."</p>
                    </div>
                    <div class='fichaje_equipos'>
                        <div class='equipo_fichaje'>
                            <a href=''>
                                <img src='".$datoFichaje->teams->out->logo."' alt='Logo'>
                                <p>".$datoFichaje->teams->out->name."</p>
                            </a>
                        </div>
                        <div class='tipo_fichaje'><p>";
                            $fichajes .= match ($datoFichaje->type) {
                                "Loan" => "Cedido",
                                "Free" => "Gratis",
                                "N/A" => "",
                                default => $datoFichaje->type
                            };
                            $fichajes .= "</p>
                            <p>
                                <i class='fa-sharp fa-solid fa-chevron-right'></i>
                                <i class='fa-sharp fa-solid fa-chevron-right'></i>
                                <i class='fa-sharp fa-solid fa-chevron-right'></i>
                            </p>
                        </div>
                        <div class='equipo_fichaje'>
                            <a href=''>
                                <img src='".$datoFichaje->teams->in->logo."' alt='Logo'>
                                <p>".$datoFichaje->teams->in->name."</p>
                            </a>
                        </div>
                    </div>".
                "</div>";
    
            }
        }
    }

    return $fichajes;
}