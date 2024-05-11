<main>
    <h1 class="titulo_pagina">Competiciones</h1>
    <article>
        <section class="seccion_buscador">
            <form id="buscar_competicion">
                <div class="buscador">
                    <label for="competiciones" class="icono_busqueda">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </label>
                    <input type="text" name="competicion" list="listaCompeticiones" placeholder="Busca una competición" onkeyup="buscarCompeticion(this.value, 'listaCompeticiones')">
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
            <form class="formulario_buscar" id="buscarEquipo">
                <div class="buscador">
                    <label for="competiciones" class="icono_busqueda">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </label>
                    <input type="text" name="competicion" id="buscador_competicion" list="listaCompeticiones2" placeholder="Busca una competición" onkeyup="buscarCompeticion(this.value, 'listaCompeticiones2')">
                </div>
                <datalist id="listaCompeticiones2"></datalist>
                <select name="equipos_competicion" id="equipos_competicion" class="seleccionar">
                    <option>Debe buscar una competición</option>
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

        let url = "../controller/competicion_clasificacion.php?competicion=" + encodeURIComponent(competicionInput);
        window.location.href = url;

    });

    /* Buscar Equipo */

    let buscadorCompeticion = document.getElementById("buscador_competicion");
    let selectEquipos = document.getElementById("equipos_competicion");

    buscadorCompeticion.addEventListener("blur", () => {

        let datalist = document.getElementById("listaCompeticiones2");
        let competicionInput = datalist.firstElementChild.getAttribute('data-idCompeticion');

        fetch("../controller/seleccionar_equipos2.php?competicion="+competicionInput)
        .then(resultado => resultado.text())
        .then(resultado => {

            if (resultado != "") {
                
                selectEquipos.innerHTML = resultado;
                
            } else {
                selectEquipos.innerHTML = "<option>Seleccione una liga</option>";
            }
            

        })
        .catch(error => {
            console.error('Fetch error:', error); // Manejo de errores
        });
    })

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