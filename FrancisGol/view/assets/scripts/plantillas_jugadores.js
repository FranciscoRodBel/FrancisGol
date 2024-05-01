function recogerClasesFormaciones(nuevaFormacion) {

    return fetch('../model/generarClasesJugador.php?formacion=' + nuevaFormacion)
    .then(response => response.json())
    .then(posicionesJugador => {

        return posicionesJugador;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

async function cambiarformacion() {

    let formacionEquipo = document.querySelector(".formacion_equipo");
    let nuevaFormacion = selectFormaciones.value;

    formacionEquipo.classList.remove(formacionEquipo.classList[1]);
    formacionEquipo.classList.add("formacion_" + nuevaFormacion);

    try {

        let clasesJugadores = await recogerClasesFormaciones(nuevaFormacion);

        let contador = 0;

        for (const jugador of formacionEquipo.children) {

            jugador.setAttribute("class", clasesJugadores[contador++]);
        }

    } catch (error) {
        console.error('Error:', error);
    }
}

/* Movimiento de los jugadores */
function listenersMovimientoJugadores() {
    let jugadores = document.querySelectorAll('.seccion_plantilla div[draggable]');

    for (const jugador of jugadores) {

        jugador.addEventListener("dragstart", function () { // Al empezar a mover el jugador...
            jugador.classList.add("ocultarJugador");
        });

        jugador.addEventListener("dragend", function () { // Al soltar el jugador
            jugador.classList.remove("ocultarJugador");
        });

        jugador.addEventListener("dragenter", function (evento) { // Al posicionarse encima del jugador...
            evento.preventDefault();
            jugador.classList.add("dentroJugador");
        });

        jugador.addEventListener("dragover", function (evento) { // El evento se produce mientras se mueve el jugador
            evento.preventDefault();
        });

        jugador.addEventListener("dragleave", function () { // Al salir del jugador
            jugador.classList.remove("dentroJugador");
        });

        jugador.addEventListener("drop", function (evento) { // Al soltar el jugador
            
            evento.preventDefault();
            let jugadorArrastrado = document.querySelector(".ocultarJugador");
            let hermanoJugador;

            jugadorArrastrado.classList.remove("ocultarJugador");
            jugador.classList.remove("dentroJugador");

            let jugadorSoltado = jugadorArrastrado.getAttribute("class");
            let jugadorTapado = jugador.getAttribute("class");

            if (jugadorSoltado != jugadorTapado) {

                jugadorArrastrado.classList.remove(jugadorSoltado);
                jugador.classList.remove(jugadorTapado);

                jugador.classList.add(jugadorSoltado);
                jugadorArrastrado.classList.add(jugadorTapado);

                if (jugadorArrastrado.previousSibling == null) {

                    hermanoJugador = jugadorArrastrado.nextSibling;
                    jugador.parentNode.insertBefore(jugadorArrastrado, jugador.nextSibling);
                    hermanoJugador.parentNode.insertBefore(jugador, hermanoJugador.parentNode.firstChild);

                } else {

                    if (jugadorArrastrado.previousSibling == jugador) {
                        
                        jugador.parentNode.insertBefore(jugador, jugadorArrastrado.nextSibling);

                    } else {
                        hermanoJugador = jugadorArrastrado.previousSibling;
                        jugador.parentNode.insertBefore(jugadorArrastrado, jugador.nextSibling);
                        hermanoJugador.parentNode.insertBefore(jugador, hermanoJugador.nextSibling);
                    }
                    
                }
            }
            
        });
    }
}


/* Guardar jugadores */
function recogerJugadores(datosPlantilla, evento) {
    evento.preventDefault();
    let jugadores = document.querySelectorAll('.seccion_plantilla div[draggable]');
    let posicionesJugadores = {};

    for (const jugador of jugadores) {

        let idJugador = jugador.getAttribute("data-idJugador");
        let posicion = jugador.getAttribute("class");
        posicionesJugadores[idJugador] = posicion;
    } 

    guardarJugadores(posicionesJugadores, datosPlantilla);
}


function guardarJugadores(posicionesJugadores, datosPlantilla) {

    let tituloPlantilla = document.getElementById("titulo_plantilla").value;
    let formacion = document.getElementById("formacion").value;

    posicionesJugadores = JSON.stringify(posicionesJugadores);
    datosPlantilla = JSON.stringify(datosPlantilla);

    let ruta = "../controller/guardar_plantillas.php";
    let datos = {
        posicionesJugadores: posicionesJugadores,
        titulo: tituloPlantilla,
        formacion: formacion,
        datosPlantilla: datosPlantilla
    };

    let opciones = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    };

    return fetch(ruta, opciones)
        .then(response => response.text())
        .then(mensajeError => {
            console.log(mensajeError);
        })
        .catch(error => {
            console.error('Error:', error);
        });
}

