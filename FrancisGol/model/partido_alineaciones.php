<?php
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