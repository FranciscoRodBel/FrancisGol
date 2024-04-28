function seleccionarAniosCompeticiones(opcionesAnios, idEquipo) {

    let competicionesAnios = document.getElementById("competicionesAnios");
    let selectCompeticiones = document.getElementById("competiciones");
    let idCompeticion = selectCompeticiones.value;

    competicionesAnios.innerHTML = opcionesAnios[idCompeticion];
    
    let anio = competicionesAnios.value;
    seleccionarDatosCompeticion(idEquipo, anio, idCompeticion);

    selectCompeticiones.addEventListener("change", () => {

        competicionesAnios.innerHTML = opcionesAnios[idCompeticion];

    });
}


function seleccionarDatosCompeticion(idEquipo, anio, idCompeticion) {

    fetch("../controller/seleccionar_estadísticas.php?idEquipo="+idEquipo+"&anio="+anio+"&idCompeticion="+idCompeticion) // Hago la petición para recoger el documento
    .then(respuesta => respuesta.text()) // Convierto a formato json la información del archivo
    .then(contenidoPagina => console.log(contenidoPagina)) // Envío la información a la función que generará los inputs
    .catch(error => console.log(error)) // En caso de que haya un error lo mostrará por consola
}