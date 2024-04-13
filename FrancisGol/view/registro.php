<main>
    <h1 class="titulo_pagina">Registro de usuario</h1>
    <article>
        <form action="#" method="POST">
            <section class="cuadro_inicio_registro">
                    <label for="email">Email</label>
                    <input type="text" name="email" placeholder="Email">
                    <label for="contrasenia">Contraseña</label>
                    <input type="password" name="contrasenia" placeholder="Contraseña">
                    <label for="repetir_contrasenia">Repetir contraseña</label>
                    <input type="password" name="repetir_contrasenia" placeholder="Contraseña">
                    <button class="boton_gris">Siguiente</button>   
            </section>


            <section class="cuadro_inicio_registro">
                <img class="foto_perfil" src="../view/assets/images/foto_perfil.png" alt="Foto de perfil">
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
                    <input type="submit" value="Registrarse" name="iniciar_sesion">
                </div>
            </section>
        </form>
    </article>
</main>
<script>

    function seleccionarDatos(selectFormulario, rutaController, divPintarDatos, condicion) {

        let idPais = $(selectFormulario).val();
        $.ajax({
            url: rutaController,
            method: 'POST',
            data: {
                query: idPais
            },
            success: function(datos) {
                $(divPintarDatos).html(datos);
                
                
                if (condicion) {

                    seleccionarDatos("#competiciones2", "../controller/seleccionar_equipos.php", '#equipos_competicion', false);
                }

            }
        });
    }

    let pais1 = document.getElementById("seleccionar_pais1");
    let pais2 = document.getElementById("seleccionar_pais2");
    let competiciones2 = document.getElementById("competiciones2");

    seleccionarDatos("#seleccionar_pais1", "../controller/seleccionar_competiciones.php", '#competiciones', false);
    seleccionarDatos("#seleccionar_pais2", "../controller/seleccionar_competiciones2.php", '#competiciones2', true);

    pais1.addEventListener("change", () => {

        seleccionarDatos("#seleccionar_pais1", "../controller/seleccionar_competiciones.php", '#competiciones', false);
    });
    
    pais2.addEventListener("change", () => {

        seleccionarDatos("#seleccionar_pais2", "../controller/seleccionar_competiciones2.php", '#competiciones2', true);

    });
    
    competiciones2.addEventListener("change", () => {

        seleccionarDatos("#competiciones2", "../controller/seleccionar_equipos.php", '#equipos_competicion', false);
    });
</script>