<main>
    <h1 class="titulo_pagina">Competiciones equipo</h1>
    <article>
        <section class="seccion_negra">
            <?= $datosEquipo ?>
            <div class="conjunto_botones">
                <a href="../controller/equipo_competiciones.php?equipo=<?= $idEquipo ?>" class="boton_gris"><span>Competiciones</span></a>
                <a href="../controller/equipo_estadisticas.php?equipo=<?= $idEquipo ?>" class="boton_gris"><span>Estadísticas</span></a>
                <a href="../controller/equipo_plantilla.php?equipo=<?= $idEquipo ?>" class="boton_gris"><span>Plantilla</span></a>
                <a href="../controller/equipo_fichajes.php?equipo=<?= $idEquipo ?>" class="boton_gris"><span>Fichajes</span></a>
            </div>
        </section>
        <!-- <section class="seccionClasificacion">
            <?= $tablaClasificacion ?>
        </section> -->
    </article>
</main>