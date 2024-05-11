<main>
    <h1 class="titulo_pagina">Competiciones</h1>
    <article>
        <section class="seccion_buscador">
            <form method="GET">
                <div class="buscador">
                    <label for="competiciones" class="icono_busqueda">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </label>
                    <input type="text" name="competicion" list="listaCompeticiones" placeholder="Busca una competición" onkeyup="buscarCompeticion(this.value)">
                </div>
                <datalist id="listaCompeticiones"></datalist>
                <input type="submit" value="Enviar" class="boton_enviar">
            </form>
        </section>
        <section class="seccion_negra seccion_competiciones">
            <?= $resultadoCompeticiones ?>
        </section>
    </article>
</main>
<script src="../view/assets/scripts/favoritos.js"></script>
<script>
    function buscarCompeticion(str) {

        if (str.length == 0) {

            document.getElementById("listaCompeticiones").innerHTML = "";
            return;

        } else {

            const xmlhttp = new XMLHttpRequest();

            xmlhttp.onload = function() {
                
                document.getElementById("listaCompeticiones").innerHTML = this.responseText;
            }
            
            xmlhttp.open("GET", "../controller/seleccionar_competiciones2.php?texto="+str);
            xmlhttp.send();
        }
    }

    document.querySelector("form").addEventListener("submit", function(event) {
        event.preventDefault();

        let datalist = document.getElementById("listaCompeticiones");
        let competicionInput = datalist.firstElementChild.getAttribute('data-idCompeticion');

        let url = "../controller/competicion_clasificacion.php?competicion=" + encodeURIComponent(competicionInput);
        window.location.href = url;

    });
    escucharFavoritos();
</script>