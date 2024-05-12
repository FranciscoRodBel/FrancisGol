<main>
    <h1 class="titulo_pagina">Inicio de sesión</h1>
    <article>
        <form action="../controller/inicioSesion.php" method="POST">
            <section class="cuadro_inicio_registro desocultar">
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Email" value="<?= $_POST["email"] ?? "" ?>">
                    <label for="contrasenia">Contraseña</label>
                    <i class="fa-solid fa-eye ojo_contrasenia"></i>
                    <input type="password" name="contrasenia" placeholder="Contraseña">
                    <input type="submit" value="Iniciar sesión" name="iniciarSesion" class="boton_verde">
                    <?= $resultadoFormulario ?> 
            </section>
        </form>
    </article>
</main>
<script src="../view/assets/scripts/registro.js"></script>
<script>
    mostrarOcultarContrasenia();
</script>