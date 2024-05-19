/* FUNCIONES EQUIPOS ESTADÍSTICAS */

function seleccionarAniosCompeticiones(opcionesAnios, idEquipo) {

    // Comprobará si se cambia el año o la competición de un equipo
    let competicionesAnios = document.getElementById("competicionesAnios");
    let selectCompeticiones = document.getElementById("competiciones");
    let idCompeticion = selectCompeticiones.value;

    competicionesAnios.innerHTML = opcionesAnios[idCompeticion]; // Añade al iniciar la página las opciones de los año de la competición
    
    let anio = competicionesAnios.value;
    seleccionarDatosCompeticion(idEquipo, anio, idCompeticion); // Recoge las estadísticas del equipo en una competición en un año


    selectCompeticiones.addEventListener("change", () => { // Si cambia la competición...

        let idCompeticion = selectCompeticiones.value;
        competicionesAnios.innerHTML = opcionesAnios[idCompeticion]; // Selecciono los años de esa competición
        seleccionarDatosCompeticion(idEquipo, anio, idCompeticion); // Recojo las estadísticas del equipo en la competición en un año
    });

    competicionesAnios.addEventListener("change", () => { // Si cambia el año...

        let idCompeticion = selectCompeticiones.value;
        let anio = competicionesAnios.value;
        seleccionarDatosCompeticion(idEquipo, anio, idCompeticion); // Recojo las estadísticas del equipo en la competición en un año
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

    if (contenidoPagina.length == 0) { // Si no se obtuvo nada en la consulta es que no hay estadísticas y muestro el mensaje
        
        seccion_estadisticas_equipo.innerHTML = "<p>Año no encontrado</p>";

    } else { // Si no está vacío añado las tablas de las estadísticas 

        seccion_estadisticas_equipo.innerHTML = contenidoPagina;
    }
}