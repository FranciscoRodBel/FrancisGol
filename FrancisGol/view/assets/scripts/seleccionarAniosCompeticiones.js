function seleccionarAniosCompeticiones(opcionesAnios, idEquipo) {

    let competicionesAnios = document.getElementById("competicionesAnios");
    let selectCompeticiones = document.getElementById("competiciones");
    let idCompeticion = selectCompeticiones.value;

    competicionesAnios.innerHTML = opcionesAnios[idCompeticion];
    
    let anio = competicionesAnios.value;
    seleccionarDatosCompeticion(idEquipo, anio, idCompeticion);


    selectCompeticiones.addEventListener("change", () => {

        let idCompeticion = selectCompeticiones.value;
        competicionesAnios.innerHTML = opcionesAnios[idCompeticion];
        seleccionarDatosCompeticion(idEquipo, anio, idCompeticion);
    });

    competicionesAnios.addEventListener("change", () => {

        let idCompeticion = selectCompeticiones.value;
        let anio = competicionesAnios.value;
        seleccionarDatosCompeticion(idEquipo, anio, idCompeticion);
    });
}


function seleccionarDatosCompeticion(idEquipo, anio, idCompeticion) {

    fetch("../controller/seleccionar_estadisticas.php?idEquipo="+idEquipo+"&anio="+anio+"&idCompeticion="+idCompeticion) // Hago la petición para recoger el documento
    .then(respuesta => respuesta.text()) // Convierto a formato json la información del archivo
    .then(contenidoPagina => incluirDatosEnLaPagina(contenidoPagina)) // Envío la información a la función que generará los inputs
    .catch(error => console.log(error)) // En caso de que haya un error lo mostrará por consola
}

function incluirDatosEnLaPagina(contenidoPagina) {
    let seccion_estadisticas_equipo = document.getElementById("estadisticas_equipo");
    console.log(contenidoPagina);
    seccion_estadisticas_equipo.innerHTML = contenidoPagina;

}