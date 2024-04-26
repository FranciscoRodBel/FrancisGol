<?php
function recogerJornadas($idCompeticion) {

    $archivo = "../view/assets/json/competicion_jornadas_$idCompeticion.json"; // Nombre del archivo

    // Verifica si existe un archivo y si fue modificado en el último día
    if (file_exists($archivo) && (time() - filemtime($archivo) < 86400)) {

        $datos = file_get_contents($archivo);
        $resultado = json_decode($datos);

    } else {

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://v3.football.api-sports.io/fixtures?league='.$idCompeticion.'&season=2023',
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

function generarJornadas($jornadas) {
    
    $jornada = $jornadas->response[0]->league->round;
    $contadorJornada = 1;
    $partidosTotales = "<div class='ocultarjornada' id='jornada_$contadorJornada'>";
    $opcionesPartidos = "<option value='jornada_$contadorJornada'>Jornada $contadorJornada</option>";

    foreach ($jornadas->response as $key => $partido) {

        if ($jornada != $partido->league->round) {

            $contadorJornada++;
            $opcionesPartidos .= "<option value='jornada_$contadorJornada'>Jornada $contadorJornada</option>";
            $jornada = $partido->league->round;
            $partidosTotales .= "</div><div class='ocultarjornada' id='jornada_$contadorJornada'>";

        } else {
            $partidosTotales .= '
            <div class="enfrentamiento_equipos">
                <a href="">
                    <div class="equipo_local">
                        <img src="'.$partido->teams->home->logo.'" alt="Logo">
                        <span>'.$partido->teams->home->name.'</span>
                    </div>
                    <div class="resultado_hora">
                        <p>VS</p>';
                        $partidosTotales .= '<p>'.$partido->goals->home.' - '.$partido->goals->away.'</p>';

        $partidosTotales .= '</div>
                    <div class="equipo_visitante">
                        <img src="'.$partido->teams->away->logo.'" alt="Logo">
                        <span>'.$partido->teams->away->name.'</span>
                    </div>
                </a>
            </div>
            <hr class="separacion_partidos">';
        }
        

        
        // $jornadasCompeticion .=
        // echo "<p>ID del partido: ".$jornada->fixture->id."<br>";
        // echo "Arbitro: ".$jornada->fixture->referee."<br>";
        // echo "Ciudad: ".$jornada->fixture->venue->city."<br>";
        // echo "ID Estadio: ".$jornada->fixture->venue->id."<br>";
        // echo "Estadio: ".$jornada->fixture->venue->name."<br>";
        // echo "Estado del partido: ".$jornada->fixture->status->long."<br>";
        // echo "Tipo de finalización: ".$jornada->fixture->status->short."<br>";
        // echo "Tiempo jugado: ".$jornada->fixture->status->elapsed."<br>";

        // echo "<br>Liga<br>";
        // echo "id: ".$jornada->league->id."<br>";
        // echo "Nombre: ".$jornada->league->name."<br>";
        // echo "Pais: ".$jornada->league->country."<br>";
        // echo "Año: ".$jornada->league->season."<br>";
        // echo "La jornada: ".$jornada->league->round."<br>";
        // echo "<img src=".$jornada->league->logo." alt='logo'>";
        // echo "<img src=".$jornada->league->flag." alt='bandera'><br>";

        // echo "<br>Equipos<br>";
        // echo "Equipo local:<br>";
        // echo "id: ".$jornada->teams->home->id."<br>";
        // echo "Nombre: ".$jornada->teams->home->name."<br>";
        // echo "Resultado: ".$jornada->teams->home->winner."<br>";
        // echo "<img src=".$jornada->teams->home->logo." alt='logo'><br>";

        // echo "Equipo Visitante:<br>";
        // echo "id: ".$jornada->teams->away->id."<br>";
        // echo "Nombre: ".$jornada->teams->away->name."<br>";
        // echo "Resultado: ".$jornada->teams->away->winner."<br>";
        // echo "<img src=".$jornada->teams->away->logo." alt='logo'><br>";

        // echo "<br>Resultado: ".$jornada->goals->home." - ".$jornada->goals->away."<br>";


        // echo "</p>";

    }

    return [$opcionesPartidos, $partidosTotales];
}