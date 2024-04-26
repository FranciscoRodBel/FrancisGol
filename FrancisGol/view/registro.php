<main>
    <h1 class="titulo_pagina">Registro de usuario</h1>
    <article>
        <form action="../controller/registro.php" method="POST" enctype="multipart/form-data">
            <section class="cuadro_inicio_registro">
                    <label for="nombre">Nombre usuario</label>
                    <input type="text" name="nombre" placeholder="Nombre" value="<?= $_POST["nombre"] ?? "" ?>">
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Email" value="<?= $_POST["email"] ?? "" ?>">
                    <label for="contrasenia">Contraseña</label>
                    <input type="password" name="contrasenia" placeholder="Contraseña">
                    <label for="repetir_contrasenia">Repetir contraseña</label>
                    <input type="password" name="repetir_contrasenia" placeholder="Contraseña">
                    <button class="boton_gris">Siguiente</button>   
            </section>



            <section class="cuadro_inicio_registro">
                <img class="foto_perfil" src="../view/assets/images/foto_perfil.png" alt="Foto de perfil">
                <input type="file" name="foto" id="foto" accept="image/png, image/jpeg, image/jpg">
                <button  class="seleccionar_foto">Selecciona una foto de perfil</button>
                <div class="conjunto_botones">
                    <button class="boton_gris">Anterior</button>
                    <button class="boton_gris">Siguiente</button>   
                </div>
            </section>


            <section class="cuadro_inicio_registro">
                <h3 class="titulo_informacion">Selecciona sus competiciones favoritas</h3>
                <select name="seleccionar_pais" id="seleccionar_pais1" class="seleccionar_pais">
                    <?= $paises1 ?>
                </select>
                <div id="competiciones" class="competiciones_equipos">

                </div>
                <div class="conjunto_botones">
                    <button class="boton_gris">Anterior</button>
                    <button class="boton_gris">Siguiente</button>   
                </div>
            </section>



            <section class="cuadro_inicio_registro">
                <h3 class="titulo_informacion">Selecciona sus competiciones favoritas</h3>
                <select name="seleccionar_pais"  id="seleccionar_pais2" class="seleccionar_pais">
                    <?= $paises2 ?>
                </select>
                <select name="seleccionar_competicion" id="competiciones2" class="seleccionar_pais">

                </select>
                <div id="equipos_competicion" class="competiciones_equipos">

                </div>
                <div class="conjunto_botones">
                    <button class="boton_gris">Anterior</button>
                    <input type="submit" value="Registrarse" name="registrarse">
                </div>
                <p><?= $resultadoFormulario ?></p>
            </section>
        </form>
    </article>
</main>
<script src="../view/assets/scripts/competiciones.js"></script>
<script>
    seleccionarCompeticiones();
</script>