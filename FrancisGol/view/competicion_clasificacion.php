<main>
    <h1 class="titulo_pagina">Noticias competición</h1>
    <article>
        <section class="seccion_negra">
            <?= $datosCompeticion ?>
            <div class="conjunto_botones">
                <a href="../controller/competicion_noticias.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Noticias</span></a>
                <a href="../controller/competicion_clasificacion.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Clasificación</span></a>
                <a href="../controller/competicion_jornadas.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Jornadas</span></a>
                <a href="../controller/competicion_noticias.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Equipos</span></a>
            </div>
        </section>
        <section class="seccionClasificacion">
            <?= $tablaClasificacion ?>
        </section>
    </article>
</main>