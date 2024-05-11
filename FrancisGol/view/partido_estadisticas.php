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
                <a class="boton_gris botonEquipo"><span><?= $nombreEquipoLocal ?></span></a>
                <a class="boton_gris botonEquipo"><span><?= $nombreEquipoVisitante ?></span></a>
            </div>
        </section>
        <section class="seccion_estadisticas">
            <?= $tablaEstadisticas ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/funciones.js"></script>
<script>cambiarTablaDatos(".tabla_datos");</script>