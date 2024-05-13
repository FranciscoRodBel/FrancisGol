<main>
    <h1 class="titulo_pagina">Favoritos</h1>
    <article>
        <section class="cuadro_inicio_registro desocultar">
            <h3 class="titulo_informacion">Selecciona sus competiciones favoritas</h3>
            <select name="seleccionar_pais" id="seleccionar_pais1" class="seleccionar_pais">
                <?= $paises1 ?>
            </select>
            <div id="competiciones" class="competiciones_equipos">

            </div>
        </section>

        <section class="cuadro_inicio_registro desocultar">
            <h3 class="titulo_informacion">Selecciona sus competiciones favoritas</h3>
            <select name="seleccionar_pais"  id="seleccionar_pais2" class="seleccionar_pais">
                <?= $paises2 ?>
            </select>
            <select name="seleccionar_competicion" id="competiciones2" class="seleccionar_pais">

            </select>
            <div id="equipos_competicion" class="competiciones_equipos">

            </div>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/competiciones.js"></script>
<script src="../view/assets/scripts/favoritos.js"></script>
<script>
    escucharFavoritos();
    seleccionarCompeticiones();
</script>