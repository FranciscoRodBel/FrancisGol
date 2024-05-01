<main>
    <h1 class="titulo_pagina">Crear Plantillas</h1>
    <article>
        <section class="seccion_negra seccion_negra_fichajes">
            <div class="conjunto_botones">
                <a href="../controller/mis_plantillas.php" class="boton_gris"><span>Mis plantillas</span></a>
                <a href="../controller/plantillas_usuarios.php" class="boton_gris"><span>Plantillas usuarios</span></a>
                <a href="../controller/crear_plantillas.php" class="boton_gris"><span>Crear plantillas</span></a>
            </div>
            
            <?php if (isset($_POST['enviarEquipo']) && isset($_POST['equipos_competicion'])) { ?>

                <?= $datosEquipo ?>
                <form action="../controller/guardar_plantillas.php" method="POST">
                    <input type="text" class="input_generico" placeholder="Título plantilla">
                    <select name="formacion" id="formacion" class="seleccionar">
                        <?= $optionsSelectFormaciones ?>
                    </select>
                    <input type="submit" value="Guardar" name="guardarEquipo" class="boton_verde">
                </form>

            <?php } else { ?>
                <hr>
                <form action="../controller/crear_plantillas.php" method="POST">
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
            <?php } ?>
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
