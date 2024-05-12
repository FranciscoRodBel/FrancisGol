<main>
    <h1 class="titulo_pagina">Equipo Datos</h1>
    <article>
        <section class="seccion_negra">
            <?= $datosJugador ?>
            <div class="conjunto_botones">
                <a href="../controller/jugador_datos.php?jugador=<?= $idJugador ?>" class="boton_gris"><span>Datos</span></a>
                <a href="../controller/jugador_trofeos.php?jugador=<?= $idJugador ?>" class="boton_gris"><span>Trofeos</span></a>
            </div>
            <div class="centraHorizontal">
                <select id="anioJugador" class="seleccionar">
                    <?= $optionsAniosDisponibles ?>
                </select>
            </div>
        </section>
        <section id="tablaDatosJugador">
            <?= $tablaDatosJugador ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/funciones.js"></script>
<script>
    let idJugador = <?= $idJugador ?>;
    escucharSelectAnio("anioJugador", "tablaDatosJugador", "../controller/seleccionar_datos_jugador.php?jugador="+idJugador+"&anio=");
</script>