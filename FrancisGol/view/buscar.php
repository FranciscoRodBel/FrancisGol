<main>
    <h1 class="titulo_pagina">Competiciones</h1>
    <article>
        <section class="seccion_buscador">
            <form id="buscar_competicion">
                <div class="buscador">
                    <label for="competiciones" class="icono_busqueda">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </label>
                    <input type="text" name="competicion" id="competicion" list="listaCompeticiones" placeholder="Busca una competición" onkeyup="buscarCompeticion(this.value, 'listaCompeticiones')">
                </div>
                <datalist id="listaCompeticiones"></datalist>
                <input type="submit" value="Enviar" class="boton_enviar"></input>
            </form>
        </section>
        <section class="seccion_negra seccion_competiciones">
            <?= $resultadoCompeticiones ?>
        </section>
    </article>
    <h1 class="titulo_pagina">Equipos</h1>
    <article>
        <section class="seccion_buscador">
            <form id="buscarEquipo" class="buscarEquipo">
                <select name="seleccionar_pais"  id="seleccionar_pais" class="seleccionar">
                    <?= $paises ?>
                </select>
                <select name="seleccionar_competicion" id="competiciones" class="seleccionar">

                </select>
                <select name="equipos_competicion" id="equipos_competicion" class="seleccionar">

                </select>
                <input type="submit" value="Enviar" class="boton_enviar">
            </form>
        </section>
        <section class="seccion_negra seccion_competiciones">
            <?= $resultadoEquipos ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/favoritos.js"></script>
<script src="../view/assets/scripts/fichajes.js"></script>
<script>
    seleccionarCompeticionesEquipos();
    function buscarCompeticion(str, idInput) {

        if (str.length == 0) {

            document.getElementById(idInput).innerHTML = "";
            return;

        } else {

            const xmlhttp = new XMLHttpRequest();

            xmlhttp.onload = function() {
                
                document.getElementById(idInput).innerHTML = this.responseText;
            }
            
            xmlhttp.open("GET", "../controller/seleccionar_competiciones2.php?texto="+str);
            xmlhttp.send();
        }
    }

    document.getElementById("buscar_competicion").addEventListener("submit", function(event) {
        event.preventDefault();

        let datalist = document.getElementById("listaCompeticiones");
        let competicionInput = datalist.firstElementChild.getAttribute('data-idCompeticion');
        document.getElementById("competicion").value = "";

        let url = "../controller/competicion_clasificacion.php?competicion=" + encodeURIComponent(competicionInput);
        window.location.href = url;

    });

    /* Buscar Equipo */

    document.getElementById("buscarEquipo").addEventListener("submit", function(event) {
        event.preventDefault();

        let selectEquipos = document.getElementById("equipos_competicion");

        if (!isNaN(selectEquipos.value)) {
            let url = "../controller/equipo_estadisticas.php?equipo=" + encodeURIComponent(selectEquipos.value);
            window.location.href = url;
        }


    });
    
    escucharFavoritos();
</script>