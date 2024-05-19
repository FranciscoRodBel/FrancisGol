<main>
    <h1 class="titulo_pagina">Jornadas competición</h1>
    <article>
        <section class="seccion_negra">
            <?= $datosCompeticion ?>
            <div class="conjunto_botones">
                <a href="../controller/competicion_clasificacion.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Clasificación</span></a>
                <a href="../controller/competicion_jornadas.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Jornadas</span></a>
                <a href="../controller/competicion_equipos.php?competicion=<?= $idCompeticion ?>" class="boton_gris"><span>Equipos</span></a>
            </div>
            <div class="centrar_horizontal">
                <select id="anioCompeticion" class="seleccionar">
                    <?= $optionsAniosDisponibles ?>
                </select>
            </div>
        </section>
        <section>
            <select class="seleccionar" name="jornadasCompeticion" id="jornadasCompeticion">
                <?= $opcionesJornadas ?>
            </select>
        </section>
        <section class="jornadasCompeticion" id="jornadas">
            <?= $jornadas ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/favoritos.js"></script>
<script src="../view/assets/scripts/funciones.js"></script>
<script>
    ocultarJornadas();
    escucharFavoritos();
    let idCompeticion = <?= $idCompeticion ?>;
    escucharAniosJornadas();
</script>