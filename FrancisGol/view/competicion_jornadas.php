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
        <section>
            <select class="seleccionar" name="jornadasCompeticion" id="jornadasCompeticion">
                <?= $opcionesJornadas ?>
            </select>
        </section>
        <section class="jornadasCompeticion">
            <?= $jornadas ?>
        </section>
    </article>
</main>
<script>
    let selectJornada = document.getElementById("jornadasCompeticion");
    let jornadaAnterior = document.getElementById(selectJornada.value);
    jornadaAnterior.classList.remove("ocultarjornada");

    selectJornada.addEventListener("change", () => {

        jornadaAnterior.classList.add("ocultarjornada");
        let jornadaSeleccionada = document.getElementById(selectJornada.value);
        
        jornadaSeleccionada.classList.remove("ocultarjornada");
        jornadaAnterior = jornadaSeleccionada;
    });

</script>