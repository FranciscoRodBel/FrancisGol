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
                <input type="text" class="input_generico titulo_plantilla" id="titulo_plantilla" placeholder="Título plantilla" value="<?= $tituloPlantilla ?>">
                <select name="formacion" id="formacion" class="formacion">
                    <?= $optionsSelectFormaciones ?>
                </select>
                <div class="conjunto_botones">
                    <input type="submit" value="Borrar" name="borrarEquipo" id="borrarEquipo" class="boton_rojo">
                    <input type="submit" value="Editar" name="editarEquipo" id="editarEquipo" class="boton_verde">
                </div>
            </form>
        </section>
        <section class="seccion_plantilla">
            <?= $resultadoPlantilla ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/plantillas_jugadores.js"></script>
<script src="../view/assets/scripts/favoritos.js"></script>
<script>
    let selectFormaciones = document.getElementById("formacion");
    selectFormaciones.addEventListener("change", cambiarformacion);
    listenersMovimientoJugadores();
</script>
<script>
    let boton_editar = document.getElementById("editarEquipo");
    let boton_borrar = document.getElementById("borrarEquipo");
    let datosPlantilla = <?= json_encode($equipoPlantilla) ?>;
    let idPlantilla = <?= $idPlantilla ?>;

    boton_editar.addEventListener("click", (evento) => { recogerJugadores(datosPlantilla, evento, "editar", idPlantilla); });
    boton_borrar.addEventListener("click", (evento) => { 
        
        evento.preventDefault();
        escucharBotonesPopUp(idPlantilla) 
    });
    escucharFavoritos();
</script>
