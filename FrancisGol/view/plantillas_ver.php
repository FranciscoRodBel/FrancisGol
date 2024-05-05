<main>
    <h1 class="titulo_pagina">Ver Plantillas</h1>
    <article>
        <section class="seccion_negra seccion_negra_fichajes">
            <div class="conjunto_botones">
                <a href="../controller/plantillas_mis.php" class="boton_gris"><span>Mis plantillas</span></a>
                <a href="../controller/plantillas_usuarios.php" class="boton_gris"><span>Plantillas usuarios</span></a>
                <a href="../controller/plantillas_crear.php" class="boton_gris"><span>Crear plantillas</span></a>
            </div>
            <?= $datosEquipo ?>
            <div class="datos_plantilla">
                <p>Título</p>
                <p><?= $tituloPlantilla ?></p>
                <p>Formación: <?= $formacion ?></p>
                <p>Usuario: <?= $nombreUsuario ?></p>
            </div>
        </section>
        <section class="seccion_plantilla">
            <?= $resultadoPlantilla ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/favoritos.js"></script>
<script> escucharFavoritos(); </script>