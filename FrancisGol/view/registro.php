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
                    <?= $paises ?>
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
                    <?= $paises ?>
                </select>
                <select name="seleccionar_competicion" id="competiciones2" class="seleccionar_pais">

                </select>
                <div id="equipos" class="competiciones_equipos">

                </div>
                <div class="conjunto_botones">
                    <button class="boton_gris">Anterior</button>
                    <button class="boton_gris">Siguiente</button>   
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
        var idPais = $("#seleccionar_pais1").val(); // Selecciona el valor del elemento con el id comunidadAutonoma
        
        $.ajax({ // Hace una consulta ajax a...
            url: '../controller/seleccionar_competiciones.php', // El archivo provincias
            method: 'POST', // por el método POST
            data: { // Los datos que le va a enviar son
                query: idPais // Una query con el valor de 
            },
            success: function(datos) { // Si la conexión se realiza, viene aquí con el resultado(datos)
                $('#competiciones').html(datos); // añade como texto dentro del elemento con el id provincia los datos devueltos(las provincias)

            }
        });
    });

    $(document).ready(function() {
        $("#seleccionar_pais1").change(function() {
            var idPais = $(this).val();
            $.ajax({
                url: '../controller/seleccionar_competiciones.php',
                method: 'POST',
                data: {
                    query: idPais
                },
                success: function(datos) {
                    $('#competiciones').html(datos);
                }
            });
        });
    });

    /* Seleccionar equipo */

    $(document).ready(function() { // cuando se cargue la página...
        var idPais = $("#seleccionar_pais2").val(); // Selecciona el valor del elemento con el id comunidadAutonoma
        
        $.ajax({ // Hace una consulta ajax a...
            url: '../controller/seleccionar_competiciones2.php', // El archivo provincias
            method: 'POST', // por el método POST
            data: { // Los datos que le va a enviar son
                query: idPais // Una query con el valor de 
            },
            success: function(datos) { // Si la conexión se realiza, viene aquí con el resultado(datos)
                $('#competiciones2').html(datos); // añade como texto dentro del elemento con el id provincia los datos devueltos(las provincias)

            }
        });
    });

    $(document).ready(function() {
        $("#seleccionar_pais2").change(function() {
            var idPais = $(this).val();
            $.ajax({
                url: '../controller/seleccionar_competiciones2.php',
                method: 'POST',
                data: {
                    query: idPais
                },
                success: function(datos) {
                    $('#competiciones2').html(datos);
                }
            });
        });
    });

    /* Seleccionar equipo */
    
    $(document).ready(function() { // cuando se cargue la página...
        var idPais = $("#competiciones2").val(); // Selecciona el valor del elemento con el id comunidadAutonoma
        
        $.ajax({ // Hace una consulta ajax a...
            url: '../controller/seleccionar_equipos.php', // El archivo provincias
            method: 'POST', // por el método POST
            data: { // Los datos que le va a enviar son
                query: idPais // Una query con el valor de 
            },
            success: function(datos) { // Si la conexión se realiza, viene aquí con el resultado(datos)
                $('#equipos').html(datos); // añade como texto dentro del elemento con el id provincia los datos devueltos(las provincias)

            }
        });
    });

    $(document).ready(function() {
        $("#competiciones2").change(function() {
            var idPais = $(this).val();
            $.ajax({
                url: '../controller/seleccionar_equipos.php',
                method: 'POST',
                data: {
                    query: idPais
                },
                success: function(datos) {
                    $('#equipos').html(datos);
                }
            });
        });
    });
</script>