<main>
    <h1 class="titulo_pagina">Competiciones</h1>
    <article>
        <section class="seccion_negra seccion_negra_fichajes">
            <form action="../controller/fichajes.php" method="POST">
                <h3 class="titulo_informacion">Busque fichajes de equipos</h3>
                <select name="seleccionar_pais"  id="seleccionar_pais" class="seleccionar">
                    <?= $paises ?>
                </select>
                <select name="seleccionar_competicion" id="competiciones" class="seleccionar">

                </select>
                <select name="equipos_competicion" id="equipos_competicion" class="seleccionar">

                </select>
                <input type="submit" value="Enviar" name="enviar" class="boton_enviar">
            </form>
        </section>
        <section class="fichajes">
            <?= $fichajes ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/fichajes.js"></script>
<script>
    seleccionarCompeticionesEquipos();
</script>