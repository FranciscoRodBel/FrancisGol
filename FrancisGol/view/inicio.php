<main>
    <h1 class="titulo_pagina">Inicio</h1>
    <article>
        <section class="seccion_sliders">
            <div class="slider">
                <div>
                    <h2 class="titulo_slider">¡Bienvenido a FrancisGol!</h2>
                    <p class="parrafo_slider">Tu fuente definitiva de información futbolística. Descubre datos completos de partidos, competiciones, jugadores y fichajes en un solo lugar. Navega fácilmente y mantente al día con todas las novedades del mundo del fútbol. ¡Explora ahora y vive la pasión con nosotros!</p>
                    <a class="boton_verde" href="../controller/partidos.php">Ver partidos</a>
                </div>
                <img src="../view/assets/images/slider1.png" alt="Foto slider">
            </div>
            <div class="slider">
                <div>
                    <h2 class="titulo_slider">¡Regístrate y personaliza tu experiencia!</h2>
                    <p class="parrafo_slider">Al crear una cuenta, podrás añadir tus equipos y competiciones favoritas. Así, recibirás información y actualizaciones solo de tus favoritos, viendo los partidos que más te interesan de manera rápida y sencilla. ¡Haz clic en el botón de registro y vive el fútbol a tu manera!</p>
                    <?php if (isset($_SESSION['usuario'])) { ?>
                        <a class="boton_verde" href="../controller/cuenta_favoritos.php">Añadir favoritos</a>
                    <?php } else { ?>
                        <a class="boton_verde" href="../controller/registro.php">Registrarse</a>
                    <?php } ?>
                </div>
                <img src="../view/assets/images/slider2.png" alt="Foto slider">
            </div>
            <div class="slider">
                <div>
                    <h2 class="titulo_slider">¡Crea plantillas de equipos!</h2>
                    <p class="parrafo_slider">Al registrarte, podrás seleccionar un equipo y crear una alineación con la plantilla actual del equipo seleccionado. Esta plantilla será pública para todos los usuarios, permitiéndote hacer predicciones para los partidos o mostrar cuál sería su alineación favorita del equipo.</p>
                    <a class="boton_verde" href="../controller/plantillas_crear.php">Crear plantilla</a>
                </div>
                <img src="../view/assets/images/slider3.png" alt="Foto slider">
            </div>
        </section>
        <section>
            <h2 class="titulo_slider">¡Más información sobre FrancisGol! </h2>
            <p class="parrafo_inicio">En FrancisGol, puedes acceder a la información de los partidos de fútbol sin necesidad de registrarte. Sin embargo, en la página de partidos esta funcionalidad está limitada a las cinco grandes ligas europeas (La Liga, Premier League, Ligue 1, Bundesliga y Serie A) y a las competiciones europeas más importantes, como la Champions League y la Europa League. La actualización de la información de los partidos se realiza cada media hora, mientras que el resto de los datos se actualiza diariamente.</p>
        </section>
    </article>
</main>