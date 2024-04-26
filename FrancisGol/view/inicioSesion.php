<main>
    <h1 class="titulo_pagina">Inicio de sesión</h1>
    <article>
        <form action="../controller/inicioSesion.php" method="POST">
            <section class="cuadro_inicio_registro">
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Email" value="<?= $_POST["email"] ?? "" ?>">
                    <label for="contrasenia">Contraseña</label>
                    <input type="password" name="contrasenia" placeholder="Contraseña">
                    <input type="submit" value="Iniciar sesión" name="iniciarSesion">
                    <?= $resultadoFormulario ?> 
            </section>
        </form>
    </article>
</main>