<main>
    <h1 class="titulo_pagina">Equipo estadísticas</h1>
    <article>
        <section class="seccion_negra">
            <?= $datosEquipo ?>
            <div class="conjunto_botones">
                <a href="../controller/equipo_estadisticas.php?equipo=<?= $idEquipo ?>" class="boton_gris"><span>Estadísticas</span></a>
                <a href="../controller/equipo_plantilla.php?equipo=<?= $idEquipo ?>" class="boton_gris"><span>Plantilla</span></a>
                <a href="../controller/equipo_fichajes.php?equipo=<?= $idEquipo ?>" class="boton_gris"><span>Fichajes</span></a>
            </div>
        </section>
        <section class="conjunto_botones">
            <select name="competiciones" id="competiciones" class="seleccionar">
                <?= $opcionesCompeticiones ?>
            </select>
            <select name="competicionesAnios" id="competicionesAnios" class="seleccionar">

            </select>
        </section>
        <section id="estadisticas_equipo" class="seccion_estadisticas_equipo">

        </section>
    </article>
</main>
<script src="../view/assets/scripts/seleccionarAniosCompeticiones.js"></script>
<script src="../view/assets/scripts/favoritos.js"></script>
<script>
    let opcionesAnios = <?= json_encode($opcionesAnios); ?>;
    let idEquipo = <?= $idEquipo ?>;
    seleccionarAniosCompeticiones(opcionesAnios, idEquipo);
    escucharFavoritos();
</script>