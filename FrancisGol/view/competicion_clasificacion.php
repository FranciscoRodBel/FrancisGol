<main>
    <h1 class="titulo_pagina">Clasificación competición</h1>
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
        <section class="seccionClasificacion" id="tablaClasificacion">
            <?= $tablaClasificacion ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/favoritos.js"></script>
<script src="../view/assets/scripts/funciones.js"></script>
<script> 
    escucharFavoritos();
    let idCompeticion = <?= $idCompeticion ?>;
    escucharSelectAnio("anioCompeticion", "tablaClasificacion", "../controller/seleccionar_clasificacion.php?competicion="+idCompeticion+"&anio=");
</script>
