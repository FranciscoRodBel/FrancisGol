<?php
    function pintarResumenPartido($eventosPartido, $idEquipoLocal, $idEquipoVisitante) {

        foreach ($eventosPartido->response as $evento) {

            $eventosEquipos[$evento->team->id][] = $evento;

        }

        $resumenPartido = "";
        $id = $idEquipoLocal;

        for ($i=0; $i < 2; $i++) { 

            $resumenPartido .= "<div>
            <h3 class='titulo_informacion'>".$eventosEquipos[$id][0]->team->name."</h3>";

            foreach ($eventosEquipos[$id] as $evento) {

                $resumenPartido .= "
                <div class='evento'>
                    <p class='minuto'>".$evento->time->elapsed."'</p>
                ";

                $resumenPartido .= match ($evento->type) {
                    "Goal" => "<i class='fa-solid fa-futbol icono_evento'></i>",
                    "NoGoal" => "<div class='icono_evento gol_anulado'>
                                    <i class='fa-solid fa-futbol'></i>
                                    <i class='fa-solid fa-xmark'></i>
                                 </div>",
                    "Card" => $evento->detail == "Yellow Card" ? "<div class='icono_evento'><div class='tarjeta_amarilla'></div></div>" : "<div class='icono_evento'><div class='tarjeta_roja'></div></div>" ,
                    "subst" => "<i class='fa-solid fa-arrows-rotate icono_evento'></i>",
                    default => $evento->detail
                };

                $resumenPartido .= match ($evento->type) {
                    "subst" => "<div class='nombre_evento cambio'>
                                    <p>".$evento->player->name."</p>
                                    <p>".$evento->assist->name."</p>
                                </div>",
                    default => "<p class='nombre_evento'>".$evento->player->name."</p>"
                };

                $resumenPartido .= "</div>";
            }

            $resumenPartido .= $id == $idEquipoLocal ? "</div><hr>" : "</div>";

            $id = $idEquipoVisitante;
            
        }

        return $resumenPartido;
    }

    function recogerResumenPartido($idPartido) {

        $archivo = "../view/assets/json/resumen_partido".$idPartido.".json"; // Nombre del archivo

        // Verifica si existe un archivo y si fue modificado en el último día
        if (file_exists($archivo) && (time() - filemtime($archivo) < 86400)) {

            $datos = file_get_contents($archivo);
            $resultado = json_decode($datos);

        } else {
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://v3.football.api-sports.io/fixtures/events?fixture='.$idPartido,
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
?>