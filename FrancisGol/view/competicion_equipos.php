<main>
    <h1 class="titulo_pagina">Equipos competición</h1>
    <article>
        <section class="seccion_negra">
            <?= $datosCompeticion ?>
            <div class="conjunto_botones">
                <a href="../controller/competicion_clasificacion.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Clasificación</span></a>
                <a href="../controller/competicion_jornadas.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Jornadas</span></a>
                <a href="../controller/competicion_equipos.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Equipos</span></a>
            </div>
            <div class="centraHorizontal">
                <select id="anioCompeticion" class="seleccionar">
                    <?= $optionsAniosDisponibles ?>
                </select>
            </div>
        </section>
        <section class="equipo_competiciones seccion_competiciones" id="equipo_competiciones">
            <?= $equiposCompeticion ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/favoritos.js"></script>
<script src="../view/assets/scripts/funciones.js"></script>
<script> 
    escucharFavoritos();
    let idCompeticion = <?= $idCompeticion ?>;
    escucharSelectAnio("anioCompeticion", "equipo_competiciones", "../controller/seleccionar_equipos_competicion.php?competicion="+idCompeticion+"&anio=");
</script>