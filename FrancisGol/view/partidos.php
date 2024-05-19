<main>
    <h1 class="titulo_pagina">Partidos</h1>
    <article>
        <section class="fechas_partidos">
            <div>
                <?= $fechas_partidos ?>
            </div>
        </section>
        <section class="fecha_partido">
            <?= $fecha ?>
        </section>
        <?= $partidosSeleccionados ?>
    </article>
</main>
<script src="../view/assets/scripts/favoritos.js"></script>
<script src="../view/assets/scripts/funciones.js"></script>
<script> 
    escucharFavoritos();
    escucharCalendarios();
</script>