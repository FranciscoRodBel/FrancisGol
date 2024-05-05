<main>
    <h1 class="titulo_pagina">Crear Plantillas</h1>
    <article>
        <section class="seccion_negra seccion_negra_fichajes">
            <div class="conjunto_botones">
                <a href="../controller/plantillas_mis.php" class="boton_gris"><span>Mis plantillas</span></a>
                <a href="../controller/plantillas_usuarios.php" class="boton_gris"><span>Plantillas usuarios</span></a>
                <a href="../controller/plantillas_crear.php" class="boton_gris"><span>Crear plantillas</span></a>
            </div>
            
            <?php
                if (isset($_SESSION['usuario'])) {
                if (isset($_POST['enviarEquipo']) && isset($_POST['equipos_competicion'])) { 
            ?>
                <?= $datosEquipo ?>
                <form>
                    <input type="text" class="input_generico titulo_plantilla" id="titulo_plantilla" placeholder="Título plantilla">
                    <select name="formacion" id="formacion" class="formacion">
                        <?= $optionsSelectFormaciones ?>
                    </select>
                    <input type="submit" value="Guardar" name="guardarEquipo" id="guardarEquipo" class="boton_verde">
                </form>

            <?php } else { ?>
                <hr>
                <form action="../controller/plantillas_crear.php" method="POST">
                    <h3 class="titulo_informacion">Seleccione un equipo</h3>
                    <select name="seleccionar_pais"  id="seleccionar_pais" class="seleccionar">
                        <?= $paises ?>
                    </select>
                    <select name="seleccionar_competicion" id="competiciones" class="seleccionar">

                    </select>
                    <select name="equipos_competicion" id="equipos_competicion" class="seleccionar">

                    </select>
                    <input type="submit" value="Enviar" name="enviarEquipo" class="boton_enviar">
                </form>
            <?php } }?>
        </section>
        <section class="seccion_plantilla">
            <?= $plantilla ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/fichajes.js"></script>
<script src="../view/assets/scripts/plantillas_jugadores.js"></script>
<script>
    seleccionarCompeticionesEquipos();
</script>
<script>
    let selectFormaciones = document.getElementById("formacion");
    selectFormaciones.addEventListener("change", cambiarformacion);

    listenersMovimientoJugadores();
</script>
<script>
    let boton_guardar = document.getElementById("guardarEquipo");
    let datosPlantilla = <?= json_encode($equipoPlantilla) ?>;
    boton_guardar.addEventListener("click", (evento) => { recogerJugadores(datosPlantilla, evento, "guardar"); });
</script>