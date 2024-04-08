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
                    <button class="boton_siguiente_anterior">Siguiente</button>   
            </section>
            <section class="cuadro_inicio_registro">
                <img class="foto_perfil" src="../view/assets/images/foto_perfil.png" alt="Foto de perfil">
                <button  class="seleccionar_foto">Selecciona una foto de perfil</button>
                <div class="conjunto_botones">
                    <button class="boton_siguiente_anterior">Anterior</button>
                    <button class="boton_siguiente_anterior">Siguiente</button>   
                </div>
            </section>
            <section class="cuadro_inicio_registro">
                <h3 class="titulo_informacion">Selecciona sus competiciones favoritas</h3>
                <select name="seleccionar_pais" id="seleccionar_pais" class="seleccionar_pais">
                    <?= $paises ?>
                </select>
                <div id="competiciones_equipos" class="competiciones_equipos">

                </div>
                <div class="conjunto_botones">
                    <button class="boton_siguiente_anterior">Anterior</button>
                    <button class="boton_siguiente_anterior">Siguiente</button>   
                </div>
            </section>
            <section class="cuadro_inicio_registro">
                <input type="submit" value="Registrarse" name="iniciar_sesion">
            </section>
        </form>
    </article>
</main>
<script>
    $(document).ready(function() { // cuando se cargue la página...
        var idPais = $("#seleccionar_pais").val(); // Selecciona el valor del elemento con el id comunidadAutonoma
        
        $.ajax({ // Hace una consulta ajax a...
            url: '../controller/seleccionar_competiciones.php', // El archivo provincias
            method: 'POST', // por el método POST
            data: { // Los datos que le va a enviar son
                query: idPais // Una query con el valor de 
            },
            success: function(datos) { // Si la conexión se realiza, viene aquí con el resultado(datos)
                $('#competiciones_equipos').html(datos); // añade como texto dentro del elemento con el id provincia los datos devueltos(las provincias)

            }
        });
    });

    $(document).ready(function() {
        $("#seleccionar_pais").change(function() {
            var idPais = $(this).val();
            $.ajax({
                url: '../controller/seleccionar_competiciones.php',
                method: 'POST',
                data: {
                    query: idPais
                },
                success: function(datos) {
                    $('#competiciones_equipos').html(datos);
                }
            });
        });
    });
</script>