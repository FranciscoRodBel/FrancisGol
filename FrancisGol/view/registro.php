<main>
    <h1 class="titulo_pagina">Registro de usuario</h1>
    <article>
        <form action="../controller/registro_comprobar.php" method="POST" enctype="multipart/form-data">
            
            <section class="cuadro_inicio_registro desocultar">
                <label for="nombre">Nombre usuario</label>
                <input type="text" id="nombre" name="nombre" placeholder="Nombre" pattern="(?=.*[a-zA-Z].*)[\w.]{5,25}" title="Debe incluir letras, números, puntos o guiones bajos entre 5 y 25 caracteres.">
                <label for="email">Email</label>
                <input type="text" id="email" name="email" placeholder="Email" pattern="(?=.{5,70}$)[\w]+@[\w]+\.[\w]+" title="Debe incluir letras, números o guiones bajos entre 5 y 70 caracteres">
                <label for="contrasenia">Contraseña</label>
                <i class="fa-solid fa-eye ojo_contrasenia"></i>
                <input type="password" id="contrasenia" class="contrasenia" name="contrasenia" placeholder="Contraseña" pattern="(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)[\w\W]{8,50}" title="Debe incluir una mayúscula, minúscula, número y un caracter extraño entre 8 y 50 caracteres.">
                <label for="repetir_contrasenia">Repetir contraseña</label>
                <i class="fa-solid fa-eye ojo_contrasenia"></i>
                <input type="password" id="repetir_contrasenia" class="contrasenia" name="repetir_contrasenia" placeholder="Contraseña" pattern="(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)[\w\W]{8,50}" title="Debe incluir una mayúscula, minúscula, número y un caracter extraño entre 8 y 50 caracteres.">
                <div class="conjunto_botones">
                    <button class="boton_gris siguiente">Siguiente</button>
                </div>
            </section>

            <section class="cuadro_inicio_registro">
                <img class="foto_perfil" id="foto_perfil" src="../view/assets/images/foto_perfil.png" alt="Foto de perfil">
                <input type="file" name="inputFoto" class="inputFoto" id="inputFoto" accept="image/png, image/jpeg, image/jpg">
                <button  class="seleccionar_foto" id="seleccionar_foto">Selecciona una foto de perfil</button>
                <div class="conjunto_botones">
                    <button class="boton_gris anterior">Anterior</button>
                    <button class="boton_gris siguiente">Siguiente</button>   
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
                    <button class="boton_gris anterior">Anterior</button>
                    <button class="boton_gris siguiente ocultar" id="competicion_seleccionada">Siguiente</button> 
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
                    <button class="boton_gris anterior">Anterior</button>
                    <input type="submit" id="registro" value="Registrarse" name="registrarse" class="boton_verde ocultar">
                </div>
                <p id="resultado_formulario" class='titulo_informacion'></p>
            </section>
        </form>
    </article>
</main>
<script src="../view/assets/scripts/competiciones.js"></script>
<script src="../view/assets/scripts/registro.js"></script>
<script>
    var favoritos = {
        "competicion": [],
        "equipo": []
    };
    seleccionarCompeticiones();
    escucharFormularios();
    comprobarInputs();
    mostrarOcultarContrasenia();
</script>
