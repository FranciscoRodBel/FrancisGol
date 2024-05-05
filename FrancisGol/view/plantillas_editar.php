<main>
    <h1 class="titulo_pagina">Editar Plantillas</h1>
    <article>
        <section class="seccion_negra seccion_negra_fichajes">
            <div class="conjunto_botones">
                <a href="../controller/plantillas_mis.php" class="boton_gris"><span>Mis plantillas</span></a>
                <a href="../controller/plantillas_usuarios.php" class="boton_gris"><span>Plantillas usuarios</span></a>
                <a href="../controller/plantillas_crear.php" class="boton_gris"><span>Crear plantillas</span></a>
            </div>
            <?= $datosEquipo ?>
            <form>
                <input type="text" class="input_generico" id="titulo_plantilla" placeholder="Título plantilla" value="<?= $titulo ?>">
                <select name="formacion" id="formacion" class="seleccionar">
                    <?= $optionsSelectFormaciones ?>
                </select>
                <input type="submit" value="Editar" name="editarEquipo" id="editarEquipo" class="boton_verde">
            </form>
        </section>
        <section class="seccion_plantilla">
            <?= $resultadoPlantilla ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/plantillas_jugadores.js"></script>
<script>
    let selectFormaciones = document.getElementById("formacion");
    selectFormaciones.addEventListener("change", cambiarformacion);
    listenersMovimientoJugadores();
</script>
<script>
    let boton_editar = document.getElementById("editarEquipo");
    let datosPlantilla = <?= json_encode($equipoPlantilla) ?>;
    let idPlantilla = <?= $idPlantilla ?>;

    boton_editar.addEventListener("click", (evento) => { recogerJugadores(datosPlantilla, evento, "editar", idPlantilla); });
</script>