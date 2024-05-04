<main>
    <h1 class="titulo_pagina">Mis Plantillas</h1>
    <article>
        <section class="seccion_negra">
            <div class="conjunto_botones">
                <a href="../controller/plantillas_mis.php" class="boton_gris"><span>Mis plantillas</span></a>
                <a href="../controller/plantillas_usuarios.php" class="boton_gris"><span>Plantillas usuarios</span></a>
                <a href="../controller/plantillas_crear.php" class="boton_gris"><span>Crear plantillas</span></a>
            </div>
        </section>
        <section>
            <?= $plantillas ?>
        </section>
    </article>
</main>