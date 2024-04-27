
<?php
    // print_r($eventosPartido);

    // echo "<h3>Eventos del partido: </h3>";
    // foreach ($eventosPartido->response as $key => $evento) {

    //     echo "<p>Equipo: ".$evento->team->name."<br>";
    //     echo "Jugador: ".$evento->player->name."<br>";
    //     echo "Tipo: ".$evento->type."<br>";
    //     echo "Tiempo transcurrido: ".$evento->time->elapsed."<br>";
    //     echo "Detalle: ".$evento->detail."<br>";
    //     echo "Comentarios: ".$evento->comments."<br><br>";
    //     echo "</p>";

    // }
?>
<main>
    <h1 class="titulo_pagina">Resumen del partido</h1>
    <article>
        <section class="seccion_negra">
            <div class="enfrentamiento_equipos">
                <a href="../controller/equipo_competiciones.php?equipo=<?= $partido->teams->home->id?>">
                    <div class="equipo_local">
                        <img src="<?= $partido->teams->home->logo ?>" alt="Logo">
                        <span><?= $partido->teams->home->name ?></span>
                    </div>
                </a>
                <div class="resultado_hora">
                    <p>VS</p>
                    <p><?= $partido->goals->home.' - '.$partido->goals->away ?></p>
                </div>
                <a href="../controller/equipo_competiciones.php?equipo=<?= $partido->teams->away->id?>">
                    <div class="equipo_visitante">
                        <img src="<?= $partido->teams->away->logo ?>" alt="Logo">
                        <span><?= $partido->teams->away->name ?></span>
                    </div>
                </a>
            </div>
            <div class="conjunto_botones">
                <a href="../controller/partido_resumen.php?partido=<?= $idPartido ?>" class="boton_gris"><span>Resumen</span></a>
                <a href="../controller/partido_estadisticas.php?partido=<?= $idPartido ?>" class="boton_gris"><span>Estadísticas</span></a>
                <a href="../controller/partido_alineaciones.php?partido=<?= $idPartido ?>" class="boton_gris"><span>Alineaciones</span></a>
            </div>
            <hr>
            <div class='eventos_partidos'>
                <?= $resumenPartido ?>
            </div>
        </section>
    </article>
</main>