<main>
    <h1 class="titulo_pagina">Equipo Trofeos</h1>
    <article>
        <section class="seccion_negra">
            <?= $datosJugador ?>
            <div class="conjunto_botones">
                <a href="../controller/jugador_datos.php?jugador=<?= $idJugador ?>" class="boton_gris"><span>Datos</span></a>
                <a href="../controller/jugador_trofeos.php?jugador=<?= $idJugador ?>" class="boton_gris"><span>Trofeos</span></a>
            </div>
        </section>
        <section>
            <?= $datosTrofeosJugador ?>
        </section>
    </article>
</main>