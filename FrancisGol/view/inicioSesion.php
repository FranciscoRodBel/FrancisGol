<main>
    <h1 class="titulo_pagina">Inicio de sesión</h1>
    <article>
        <form action="../controller/inicio_comprobar.php" method="POST">
            <section class="cuadro_inicio_registro desocultar">
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Email" value="<?= $_POST["email"] ?? "" ?>">
                    <label for="contrasenia">Contraseña</label>
                    <i class="fa-solid fa-eye ojo_contrasenia"></i>
                    <input type="password" name="contrasenia" placeholder="Contraseña">
                    <input type="submit" value="Iniciar sesión" id="iniciarSesion" name="iniciarSesion" class="boton_verde">
                    <p id="resultado_formulario" class='titulo_informacion'></p>
            </section>
        </form>
    </article>
</main>
<script src="../view/assets/scripts/registro.js"></script>
<script>
    mostrarOcultarContrasenia();

    let botonInicio = document.getElementById("iniciarSesion");

    botonInicio.addEventListener("click", comprobarInicio);

    function comprobarInicio(evento) {
    
        evento.preventDefault();

        let parrafoResultado = document.getElementById("resultado_formulario");
        let formulario = document.querySelector("form");

        let formData = new FormData(formulario);

        let opcionesFetch = {
            method: 'POST',
            body: formData
        };

        parrafoResultado.innerHTML = "<div class='cargando'></div>";

        fetch(formulario.getAttribute('action'), opcionesFetch)
        .then(resultado => resultado.text())
        .then(respuesta => {

            if (respuesta.length == 0) {
                
                window.location.href = "../controller/partidos.php";

            } else {

                parrafoResultado.innerHTML = respuesta;
            }


        })
        .catch(error => {
            console.error('Error:', error);
        });
    }
</script>