function escucharCalendarios() {
    
    let inputCalendario = document.querySelectorAll(".inputCalendario");

    for (const calendario of inputCalendario) {
        
        calendario.addEventListener("input", () => {
          
            window.location.href = "../controller/partidos.php?fecha="+calendario.value;
        })

    }
}

function cambiarTablaDatos(datoEquipo) {
    
    let botonesEquipos = document.querySelectorAll(".botonEquipo");
    let datosEquipos = document.querySelectorAll(datoEquipo);

    botonesEquipos[0].addEventListener("click", () => {

        datosEquipos[0].classList.remove("ocultar");
        datosEquipos[1].classList.add("ocultar");

    })

    botonesEquipos[1].addEventListener("click", () => {

        datosEquipos[0].classList.add("ocultar");
        datosEquipos[1].classList.remove("ocultar");

    })
}

/* Página de competiciones */
function escucharSelectAnio(selectAnio, divDatos, consulta) {
    let anioSeleccionado = document.getElementById(selectAnio);
    let divMostrarDatos = document.getElementById(divDatos);

    anioSeleccionado.addEventListener("change", () => {
        
        fetch(consulta+anioSeleccionado.value)
        .then(respuesta => respuesta.text())
        .then(contenidoPagina => {
            
            divMostrarDatos.innerHTML = contenidoPagina;
            seleccionarEstadisticasJugador();
        })
        .catch(error => console.log(error));
    });
}

function escucharAniosJornadas() {
    let anioSeleccionado = document.getElementById("anioCompeticion");
    let divMostrarDatos = document.getElementById("jornadas");
    let selectJornadas = document.getElementById("jornadasCompeticion");

    anioSeleccionado.addEventListener("change", () => {
        
        fetch("../controller/seleccionar_jornadas.php?competicion="+idCompeticion+"&anio="+anioSeleccionado.value)
        .then(respuesta => respuesta.json())
        .then(contenidoPagina => {

            if (contenidoPagina[0].length == 0) {

                divMostrarDatos.innerHTML = "<p class='parrafo_informacion'>No se encontraron jornadas</p>";

            } else {

                divMostrarDatos.innerHTML = contenidoPagina[0];
            }

            selectJornadas.innerHTML = contenidoPagina[1];
            ocultarJornadas();
            
        })
        .catch(error => console.log(error));
    });
}

function ocultarJornadas() {
    let selectJornada = document.getElementById("jornadasCompeticion");
    let jornadaAnterior = document.getElementById(selectJornada.value);
    jornadaAnterior.classList.remove("ocultarjornada");

    selectJornada.addEventListener("change", () => {

        jornadaAnterior.classList.add("ocultarjornada");
        let jornadaSeleccionada = document.getElementById(selectJornada.value);
        
        jornadaSeleccionada.classList.remove("ocultarjornada");
        jornadaAnterior = jornadaSeleccionada;
    });
}

function seleccionarEstadisticasJugador() {

    let competicionJugador = document.getElementById("jugadorEstadisticas");

    competicionJugador.addEventListener("change", mostrarEstadisticaJugador);
}

function mostrarEstadisticaJugador() {

    let competicionJugador = document.getElementById("jugadorEstadisticas");
    
    console.log(competicionJugador);
    let competiciones = document.querySelectorAll(".competiciones");

    for (const competicion of competiciones) {

        competicion.parentElement.parentElement.parentElement.classList.add("ocultar");

        if (competicion.textContent == competicionJugador.value) {

            competicion.parentElement.parentElement.parentElement.classList.remove("ocultar");
        }
    }
}