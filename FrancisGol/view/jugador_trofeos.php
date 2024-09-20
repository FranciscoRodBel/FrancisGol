<main>
    <h1 class="titulo_pagina">Trofeos del jugador</h1>
    <article>
        <section class="seccion_negra">
            <?= $datosJugador ?>
            <div class="conjunto_botones">
                <a href="../controller/jugador_datos.php?jugador=<?= $idJugador ?>" class="boton_gris"><span>Datos</span></a>
                <a href="../controller/jugador_trofeos.php?jugador=<?= $idJugador ?>" class="boton_gris"><span>Trofeos</span></a>
            </div>
        </section>
        <section class="seccion_jugador_trofeos">
            <?= $datosTrofeosJugador ?>
        </section>
    </article>
</main>