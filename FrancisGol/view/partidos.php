<main>
    <h1 class="titulo_pagina">Partidos</h1>
    <article>
        <section class="fechas_partidos">
            <div>
                <?= $fechas_partidos ?>
            </div>
        </section>
        <?= $partidosSeleccionados ?>
    </article>
</main>
<script src="../view/assets/scripts/favoritos.js"></script>
<script> escucharFavoritos(); </script>