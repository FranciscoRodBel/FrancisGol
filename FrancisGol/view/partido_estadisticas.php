<main>
    <h1 class="titulo_pagina">Estadísticas del partido</h1>
    <article>
        <section class="seccion_negra">
            <?= $datosPartido ?>
            <div class="conjunto_botones">
                <a href="../controller/partido_resumen.php?partido=<?= $idPartido ?>" class="boton_gris"><span>Resumen</span></a>
                <a href="../controller/partido_estadisticas.php?partido=<?= $idPartido ?>" class="boton_gris"><span>Estadísticas</span></a>
                <a href="../controller/partido_alineaciones.php?partido=<?= $idPartido ?>" class="boton_gris"><span>Alineaciones</span></a>
            </div>
            <hr>
            <div class="conjunto_botones">
            <a href="" class="boton_gris"><span><?= $nombreEquipoLocal ?></span></a>
                <a href="" class="boton_gris"><span><?= $nombreEquipoVisitante ?></span></a>
            </div>
            <?= $tablaEstadisticas ?>
        </section>
    </article>
</main>