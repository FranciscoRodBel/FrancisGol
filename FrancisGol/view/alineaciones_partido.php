<main>
    <h1 class="titulo_pagina">Alineaciones del partido</h1>
    <article>
        <section class="seccion_negra">
            <div class="enfrentamiento_equipos">
                <a href="../controller/partido.php">
                    <div>
                        <img src="<?= $partido->teams->home->logo ?>" alt="Logo">
                        <span><?= $partido->teams->home->name ?></span>
                    </div>
                    <div>
                        <p>VS</p>
                        <p><?= $partido->goals->home.' - '.$partido->goals->away ?></p>
                    </div>
                    <div>
                        <img src="<?= $partido->teams->away->logo ?>" alt="Logo">
                        <span><?= $partido->teams->away->name ?></span>
                    </div>
                </a>
            </div>
            <div class="conjunto_botones">
                <a href="../controller/resumen_partido.php?partido=<?= urlencode(json_encode($partido)) ?>" class="boton_gris"><span>Resumen</span></a>
                <a href="../controller/estadisticas_partido.php?partido=<?= urlencode(json_encode($partido)) ?>" class="boton_gris"><span>Estadísticas</span></a>
                <a href="../controller/alineaciones_partido.php?partido=<?= urlencode(json_encode($partido)) ?>" class="boton_gris"><span>Alineaciones</span></a>
            </div>
            <hr>
            <div class="conjunto_botones">
                <a href="" class="boton_gris"><span>Celta de Vigo</span></a>
                <a href="" class="boton_gris"><span>Rayo Vallecano</span></a>
            </div>
            <div class="alineacion">
                <div>
                    <img src="../view/assets/images/logo.png" alt="foto">
                    <p>Iago Aspas</p>
                </div>
            </div>
        </section>
    </article>
</main>