<main>
    <h1 class="titulo_pagina">Inicio de sesión</h1>
    <article>
        <form action="../controller/inicio_comprobar.php" method="POST">
            <section class="cuadro_inicio_registro desocultar">
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Email" value="<?= $_POST["email"] ?? "" ?>" pattern="(?=.{5,70}$)[\w]+@[\w]+\.[\w]+" title="Debe incluir letras, números o guiones bajos, hasta 70 caracteres">
                    <label for="contrasenia">Contraseña</label>
                    <i class="fa-solid fa-eye ojo_contrasenia"></i>
                    <input type="password" name="contrasenia" placeholder="Contraseña" pattern="(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)[\w\W]{8,50}" title="Debe incluir una mayúscula, minúscula, número y un caracter extraño entre 8 y 50 caracteres.">
                    <input type="submit" value="Iniciar sesión" id="iniciarSesion" name="iniciarSesion" class="boton_verde">
                    <p id="resultado_formulario" class='titulo_informacion'></p>
            </section>
        </form>
    </article>
</main>
<script src="../view/assets/scripts/registro.js"></script>
<script>
    mostrarOcultarContrasenia();
    inicioSesion();
</script>