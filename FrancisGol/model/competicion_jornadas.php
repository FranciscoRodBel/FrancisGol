<?php

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