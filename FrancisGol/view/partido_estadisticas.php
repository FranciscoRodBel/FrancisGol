<main>
    <h1 class="titulo_pagina">Estadísticas del partido</h1>
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
            <div class="conjunto_botones">
                <a href="" class="boton_gris"><span><?= $partido->teams->home->name ?></span></a>
                <a href="" class="boton_gris"><span><?= $partido->teams->away->name ?></span></a>
            </div>
            <?= $tablaEstadisticas ?>
        </section>
    </article>
</main>