<main>
    <h1 class="titulo_pagina">Editar Foto</h1>
    <article>
        <section class="cuadro_inicio_registro desocultar">
            <form action="../controller/cuenta_editar.php?accion=editarFoto" enctype="multipart/form-data">
                <img class="foto_perfil" id="foto_perfil" src='data:image/jpeg;base64, <?= base64_encode($fotoUsuario) ?>' alt="Foto de perfil">
                <input type="file" name="inputFoto" class="inputFoto" id="inputFoto" accept="image/png, image/jpeg, image/jpg">
                <button  class="seleccionar_foto" id="seleccionar_foto">Selecciona una foto de perfil</button>
                <input type="submit" id="editarFoto" value="Editar foto" name="editarFoto" class="boton_verde">
                <p class='parrafo_informacion_blanco'></p>
            </form>
        </section>
        <h1 class="titulo_pagina">Editar Datos</h1>
        <section class="cuadro_inicio_registro desocultar">
            <form action="../controller/cuenta_editar.php?accion=editarDatos">
                <label for="nombre">Nombre usuario</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" value="<?= $nombreUsuario ?>">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email" value="<?= $emailUsuario ?>">
                <label for="contrasenia">Confirmar Contraseña</label>
                <i class="fa-solid fa-eye ojo_contrasenia"></i>
                <input type="password" id="contrasenia" class="contrasenia" name="contrasenia" placeholder="Contraseña">
                <input type="submit" id="editarDatos" value="Editar datos" name="editarDatos" class="boton_verde">
                <p class='parrafo_informacion_blanco'></p>            
            </form>
        </section>
        <h1 class="titulo_pagina">Editar Contraseña</h1>
        <section class="cuadro_inicio_registro desocultar">
            <form action="../controller/cuenta_editar.php?accion=editarContrasenia">
                <label for="contrasenia">Nueva Contraseña</label>
                <i class="fa-solid fa-eye ojo_contrasenia"></i>
                <input type="password" id="nueva_contrasenia" class="contrasenia" name="nueva_contrasenia" placeholder="Nueva contraseña">
                <label for="repetir_contrasenia">Repetir contraseña</label>
                <i class="fa-solid fa-eye ojo_contrasenia"></i>
                <input type="password" id="repetir_contrasenia" class="contrasenia" name="repetir_contrasenia" placeholder="Nueva contraseña">
                <label for="repetir_contrasenia">Contraseña actual</label>
                <i class="fa-solid fa-eye ojo_contrasenia"></i>
                <input type="password" id="contrasenia_actual" class="contrasenia" name="contrasenia_actual" placeholder="Contraseña actual">
                     
                
                <input type="submit" id="editarContrasenia" value="Editar contraseña" name="editarContrasenia" class="boton_verde">
                <p class='parrafo_informacion_blanco'></p>            
            </form>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/registro.js"></script>
<script>
    mostrarOcultarContrasenia();
    escucharFormulariosEditar();
    comprobarInputsEditar();
    comprobarInputs();

</script>
