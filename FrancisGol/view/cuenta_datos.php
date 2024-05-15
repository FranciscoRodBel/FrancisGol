<main>
    <h1 class="titulo_pagina">Editar</h1>
    <article>
        <section class="cuadro_inicio_registro desocultar">
            <form action="../controller/cuenta_editar.php?accion=editarFoto" enctype="multipart/form-data">
                <img class="foto_perfil" id="foto_perfil" src='data:image/jpeg;base64, <?= base64_encode($fotoUsuario) ?>' alt="Foto de perfil">
                <input type="file" name="inputFoto" class="inputFoto" id="inputFoto" accept="image/png, image/jpeg, image/jpg">
                <button  class="seleccionar_foto" id="seleccionar_foto">Selecciona una foto de perfil</button>
                <input type="submit" id="editarFoto" value="Editar Foto" name="editarFoto" class="boton_verde">
                <p class='parrafo_informacion_blanco'></p>
            </form>
        </section>
        <section class="cuadro_inicio_registro desocultar">
            <form action="../controller/cuenta_editar.php?accion=foto" enctype="multipart/form-data">
                <label for="nombre">Nombre usuario</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?= $nombreUsuario ?>">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email" value="<?= $emailUsuario ?>">
                <label for="contrasenia">Contraseña</label>
                <i class="fa-solid fa-eye ojo_contrasenia"></i>
                <input type="password" id="contrasenia" class="contrasenia" name="contrasenia" placeholder="Contraseña">
                <!-- <input type="submit" id="editarFoto" value="Editar Foto" name="editarFoto" class="boton_verde"> -->
            </form>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/registro.js"></script>
<script>
    escucharFormulariosEditar();
    comprobarInputs();
    mostrarOcultarContrasenia();
</script>
