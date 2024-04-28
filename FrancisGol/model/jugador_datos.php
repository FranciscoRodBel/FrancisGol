<?php

function pintarDatosJugador($datosJugador) {

    $tablaDatosJugador = "<table class='tabla_datos'>
    <thead><tr><th colspan='2'>Datos</th></tr></thead><tbody>";
    
    foreach($datosJugador->response as $jugador) {

        $tablaDatosJugador .= "<tr><td>Apodo</td><td>".$jugador->player->name."</td></tr>
        <tr><td>Nombre</td><td>".$jugador->player->firstname."</td></tr>
        <tr><td>Apellidos</td><td>".$jugador->player->lastname."</td></tr>
        <tr><td>Edad</td><td>".$jugador->player->age."</td></tr>
        <tr><td>Fecha nacimiento</td><td>".$jugador->player->birth->date."</td></tr>
        <tr><td>Lugar de nacimiento</td><td>".$jugador->player->birth->place."</td></tr>
        <tr><td>País de nacimiento</td><td>".$jugador->player->birth->country."</td></tr>
        <tr><td>Nacionalidad</td><td>".$jugador->player->nationality."</td></tr>
        <tr><td>Altura</td><td>".$jugador->player->height."</td></tr>
        <tr><td>Peso</td><td>".$jugador->player->weight."</td></tr>
        <tr><td>Lesionado</td><td>".$jugador->player->injured."</td></tr>";

        foreach ($jugador->statistics as $estadistica) {

            $tablaDatosJugador .= "<tr><td>Equipo</td><td>".$estadistica->team->name."</td></tr>
            <tr><td>Competición</td><td>".$estadistica->league->name."</td></tr>
            <tr><td>País</td><td>".$estadistica->league->country."</td></tr>
            <tr><td>Año</td><td>".$estadistica->league->season."</td></tr>
            <tr><td>Partidos jugados</td><td>".$estadistica->games->appearences."</td></tr>
            <tr><td>Veces alineado</td><td>".$estadistica->games->lineups."</td></tr>
            <tr><td>Minutos jugados</td><td>".$estadistica->games->minutes."</td></tr>
            <tr><td>Dorsal</td><td>".$estadistica->games->number."</td></tr>
            <tr><td>Posición</td><td>".$estadistica->games->position."</td></tr>
            <tr><td>Puntuación</td><td>".$estadistica->games->rating."</td></tr>
            <tr><td>Capitán</td><td>".$estadistica->games->captain."</td></tr>
            <tr><td>Entrar de cambio</td><td>".$estadistica->substitutes->in."</td></tr>
            <tr><td>Salir de cambio</td><td>".$estadistica->substitutes->out."</td></tr>
            <tr><td>Suplente</td><td>".$estadistica->substitutes->bench."</td></tr>
            <tr><td>Total de tiros</td><td>".$estadistica->shots->total."</td></tr>
            <tr><td>Tiros a puerta</td><td>".$estadistica->shots->on."</td></tr>
            <tr><td>Goles</td><td>".$estadistica->goals->total."</td></tr>
            <tr><td>Asistencias</td><td>".$estadistica->goals->assists."</td></tr>
            <tr><td>Goles salvados</td><td>".$estadistica->goals->saves."</td></tr>
            <tr><td>Goles concedidos</td><td>".$estadistica->goals->conceded."</td></tr>
            <tr><td>Total de pases</td><td>".$estadistica->passes->total."</td></tr>
            <tr><td>Pases clave</td><td>".$estadistica->passes->key."</td></tr>
            <tr><td>Pases precisos</td><td>".$estadistica->passes->accuracy."</td></tr>
            <tr><td>Encontronazos</td><td>".$estadistica->tackles->total."</td></tr>
            <tr><td>Encontronazos bloqueados</td><td>".$estadistica->tackles->blocks."</td></tr>
            <tr><td>Intercepciones</td><td>".$estadistica->tackles->interceptions."</td></tr>
            <tr><td>Duelos</td><td>".$estadistica->duels->total."</td></tr>
            <tr><td>Duelos ganados</td><td>".$estadistica->duels->won."</td></tr>
            <tr><td>Regates realizados</td><td>".$estadistica->dribbles->attempts."</td></tr>
            <tr><td>Regates realizados con exito</td><td>".$estadistica->dribbles->success."</td></tr>
            <tr><td>Regates realizados sin exito</td><td>".$estadistica->dribbles->past."</td></tr>
            <tr><td>Faltas recibidas</td><td>".$estadistica->fouls->drawn."</td></tr>
            <tr><td>Faltas cometidas</td><td>".$estadistica->fouls->committed."</td></tr>
            <tr><td>Tarjetas amarillas</td><td>".$estadistica->cards->yellow."</td></tr>
            <tr><td>Tarjetas roja por amarillas</td><td>".$estadistica->cards->yellowred."</td></tr>
            <tr><td>Tarjetas roja</td><td>".$estadistica->cards->red."</td></tr>
            <tr><td>Penaltis ganados</td><td>".$estadistica->penalty->won."</td></tr>
            <tr><td>Penaltis cometidos</td><td>".$estadistica->penalty->commited."</td></tr>
            <tr><td>Penaltis marcados</td><td>".$estadistica->penalty->scored."</td></tr>
            <tr><td>Penaltis fallados</td><td>".$estadistica->penalty->missed."</td></tr>
            <tr><td>Penaltis parados</td><td>".$estadistica->penalty->saved."</td></tr>";
        }
    }
    
    $tablaDatosJugador .= "</tbody></table>";
    
    return $tablaDatosJugador;
    
}