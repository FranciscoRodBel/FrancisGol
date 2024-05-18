<main>
    <h1 class="titulo_pagina">Competiciones</h1>
    <article>
        <section class="seccion_buscador">
            <form id="buscar_competicion">
                <div class="buscador">
                    <label for="competiciones" class="icono_busqueda">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </label>
                    <input type="text" name="competicion" id="competicion" list="listaCompeticiones" placeholder="Busca una competición">
                </div>
                <datalist id="listaCompeticiones"></datalist>
                <input type="submit" value="Enviar" class="boton_enviar"></input>
            </form>
        </section>
        <section class="seccion_negra seccion_competiciones seccion_buscar">
            <?= $resultadoCompeticiones ?>
        </section>
    </article>
    <h1 class="titulo_pagina">Equipos</h1>
    <article>
        <section class="seccion_buscador">
            <form id="buscarEquipo" class="buscarEquipo">
                <select name="seleccionar_pais"  id="seleccionar_pais" class="seleccionar">
                    <?= $paises ?>
                </select>
                <select name="seleccionar_competicion" id="competiciones" class="seleccionar">

                </select>
                <select name="equipos_competicion" id="equipos_competicion" class="seleccionar">

                </select>
                <input type="submit" value="Enviar" class="boton_enviar">
            </form>
        </section>
        <section class="seccion_negra seccion_competiciones seccion_buscar">
            <?= $resultadoEquipos ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/favoritos.js"></script>
<script src="../view/assets/scripts/fichajes.js"></script>
<script src="../view/assets/scripts/funciones.js"></script>
<script>
    seleccionarCompeticionesEquipos();
    detectarPulsacionesInput();
    escucharEnviosFormulariosBusqueda();
    escucharFavoritos();
</script>