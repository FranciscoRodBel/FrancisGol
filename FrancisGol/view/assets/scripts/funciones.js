
/* FUNCIONES PÁGINA DE PARTIDOS */

function escucharCalendarios() {
    
    let inputCalendario = document.querySelectorAll(".inputCalendario");

    for (const calendario of inputCalendario) { // Escucha si se cambio la fecha de los calendarios de las fechas de la parte superior de la página
        
        calendario.addEventListener("input", () => {
          
            window.location.href = "../controller/partidos.php?fecha="+calendario.value;
        })

    }
}

/* FUNCIONES PÁGINA DE PARTIDOS */
function cambiarTablaDatos(datoEquipo) { // Se usa para cambiar la información de la página de un equipo a otro
    
    let botonesEquipos = document.querySelectorAll(".botonEquipo");
    let datosEquipos = document.querySelectorAll(datoEquipo);

    // Si se pulsa en uno se muestra y se oculta el anterior
    botonesEquipos[0].addEventListener("click", () => {

        datosEquipos[0].classList.remove("ocultar");
        datosEquipos[1].classList.add("ocultar");

    })

    botonesEquipos[1].addEventListener("click", () => {

        datosEquipos[0].classList.add("ocultar");
        datosEquipos[1].classList.remove("ocultar");

    })
}


/* FUNCIONES PÁGINA DE COMPETICIONES */

function escucharSelectAnio(selectAnio, divDatos, consulta) { // Escucha si cambia el año de la competición para actualizar los datos de la competición

    let anioSeleccionado = document.getElementById(selectAnio);
    let divMostrarDatos = document.getElementById(divDatos);

    anioSeleccionado.addEventListener("change", () => { // Escucho si cambia de año
        
        fetch(consulta+anioSeleccionado.value) // se hace la consulta para recoger los nuevos datos
        .then(respuesta => respuesta.text())
        .then(contenidoPagina => {
            
            divMostrarDatos.innerHTML = contenidoPagina;
            seleccionarEstadisticasJugador();
        })
        .catch(error => console.log(error));
    });
}

function escucharAniosJornadas() { // Si cambia el año en las jornadas recoge las nuevas jornadas

    let anioSeleccionado = document.getElementById("anioCompeticion");
    let divMostrarDatos = document.getElementById("jornadas");
    let selectJornadas = document.getElementById("jornadasCompeticion");

    anioSeleccionado.addEventListener("change", () => { // Si cambia el año hace la consulta
        
        fetch("../controller/seleccionar_jornadas.php?competicion="+idCompeticion+"&anio="+anioSeleccionado.value)
        .then(respuesta => respuesta.json())
        .then(contenidoPagina => {

            if (contenidoPagina[0].length == 0) { // Si los datos están vacíos significa que no se encontraron resultados

                divMostrarDatos.innerHTML = "<p class='parrafo_informacion'>No se encontraron jornadas</p>";

            } else {

                divMostrarDatos.innerHTML = contenidoPagina[0];
            }

            selectJornadas.innerHTML = contenidoPagina[1]; // añade el HTML de las jornadas
            ocultarJornadas(); 
            
        })
        .catch(error => console.log(error));
    });
}

function ocultarJornadas() { // mostrará solo la primera jornada e irá ocultado y mostrando si se cambia de jornada

    let selectJornada = document.getElementById("jornadasCompeticion");
    let jornadaAnterior = document.getElementById(selectJornada.value);
    jornadaAnterior.classList.remove("ocultarjornada"); // Muestra la jornada

    selectJornada.addEventListener("change", () => { // Si cambia la jornada

        jornadaAnterior.classList.add("ocultarjornada"); // Oculta la actual
        let jornadaSeleccionada = document.getElementById(selectJornada.value);
        
        jornadaSeleccionada.classList.remove("ocultarjornada"); // Muestra la nueva jornada
        jornadaAnterior = jornadaSeleccionada;
    });
}


/* FUNCIONES PÁGINA DE DATOS DEL JUAGDOR */

function seleccionarEstadisticasJugador() { // Escuchará si el jugador cambia la competición

    let competicionJugador = document.getElementById("jugadorEstadisticas");

    competicionJugador.addEventListener("change", mostrarEstadisticaJugador); // Si cambia la competición cambia la estadísiticas
}

function mostrarEstadisticaJugador() {

    let competicionJugador = document.getElementById("jugadorEstadisticas");
    
    let competiciones = document.querySelectorAll(".competiciones");

    for (const competicion of competiciones) { // Recorro todas las tablas de estadísticas de ese año

        competicion.parentElement.parentElement.parentElement.classList.add("ocultar"); // Oculto la tabla

        if (competicion.textContent == competicionJugador.value) { // Si el nombre de la competición es el mismo que el que viene en la tabla, muestra la tabla

            competicion.parentElement.parentElement.parentElement.classList.remove("ocultar"); // Muestro la nueva tabla
        }
    }
}


/* FUNCIONES PÁGINA BUSCAR */

function detectarPulsacionesInput() {
        
    let inputCompeticion = document.getElementById("competicion");

    inputCompeticion.addEventListener("keyup", () => { // Si cambia el valor del input...

        buscarCompeticion(inputCompeticion.value, 'listaCompeticiones'); // Busca competiciones

    });
}

function buscarCompeticion(str, idInput) { // Busca en el JSON una competción con el nombre buscado

    if (str.length == 0) { // Si se dejó vacío el input

        document.getElementById(idInput).innerHTML = ""; // Se eliminan las opciones
        return;

    } else {

        fetch("../controller/seleccionar_competiciones2.php?texto="+str) // Hace la consulta
        .then(response => { return response.text(); })
        .then(competiciones => {

            document.getElementById(idInput).innerHTML = competiciones; // Añade las competiciones en el datalist
        })
        .catch(error => {
            console.error('Error:', error); // Manejar errores
        });
    }
}

function escucharEnviosFormulariosBusqueda() { // Escuchará si se envía una competición o un equipo

    /* Busca competición */

    document.getElementById("buscar_competicion").addEventListener("submit", function(event) {
        
        event.preventDefault();

        let datalist = document.getElementById("listaCompeticiones"); // Recojo el datalist

        let competicionInput = datalist.firstElementChild.getAttribute('data-idCompeticion'); // Selecciono la primera opción del datalist
        document.getElementById("competicion").value = ""; // Lo vacío por si vuelve a la página después de enviarlo

        let url = "../controller/competicion_clasificacion.php?competicion=" + encodeURIComponent(competicionInput);
        window.location.href = url; // Actualizo la página

    });

    /* Busca equipo */

    document.getElementById("buscarEquipo").addEventListener("submit", function(event) {

        event.preventDefault();

        let selectEquipos = document.getElementById("equipos_competicion"); // Selecciono el equipo

        if (!isNaN(selectEquipos.value)) {
            let url = "../controller/equipo_estadisticas.php?equipo=" + encodeURIComponent(selectEquipos.value);
            window.location.href = url; // Actualizo la página
        }

    });
}

