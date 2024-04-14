<main>
    <h1 class="titulo_pagina">Competiciones</h1>
    <article>
            <section>
                <form action="#" method="POST">
                    <div class="buscador">
                        <label for="competiciones" class="icono_busqueda">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </label>
                        <input type="text" name="seleccionar_competicion" list="listaCompeticiones" placeholder="Busca una competición" onkeyup="buscarCompeticion(this.value)">
                    </div>
                    <datalist id="listaCompeticiones"></datalist>
                    <div id="equipos_competicion" class="competiciones_equipos">

                    </div>
                </form>
            </section>
            <section class="seccion_negra">

            </section>
    </article>
</main>
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
</script>