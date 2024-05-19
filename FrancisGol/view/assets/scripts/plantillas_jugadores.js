function recogerClasesFormaciones(nuevaFormacion) { // Hace una consulta que genera las clases a partir de la formación

    return fetch('../controller/generarClasesJugador.php?formacion=' + nuevaFormacion)
    .then(resultado => resultado.json())
    .then(posicionesJugador => {

        return posicionesJugador; // Devuelve el array con las clases de la formación
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

async function cambiarformacion() { // Se ejecuta de forma asíncrona ya que se tiene que ejecutar en segundo plano

    let formacionEquipo = document.querySelector(".formacion_equipo");
    let nuevaFormacion = selectFormaciones.value; // Recojo la formación

    formacionEquipo.classList.remove(formacionEquipo.classList[1]); // Elimino la clase de la formación
    formacionEquipo.classList.add("formacion_" + nuevaFormacion); // Añado la nueva clase con la nueva formación

    try {

        let clasesJugadores = await recogerClasesFormaciones(nuevaFormacion); // Creo las clases de la formación

        let contador = 0;

        for (const jugador of formacionEquipo.children) { // Recorro los jugadores y les añado las clases

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

        /* Drag and drop de jugadores*/

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

            jugadorArrastrado.classList.remove("ocultarJugador");
            jugador.classList.remove("dentroJugador");

            jugadorArrastrado.classList.remove("intercambiarJugador"); // Si pulsa en dos jugadores se le intercambian
            jugador.classList.remove("intercambiarJugador"); // Si pulsa en dos jugadores se le intercambian

            intercambiarJugadores(jugador, jugadorArrastrado);
        });

        /* Seleccionar e intercambiar jugadores*/

        jugador.addEventListener("click", function () { // Si pulsa en un jugador

            jugador.classList.toggle("intercambiarJugador"); // Le añade la clase de intercambio
            
            let jugadores = document.querySelectorAll(".intercambiarJugador"); // Recoge los jugadores con esa clase
    
            if (jugadores.length == 2) { // si son 2 los intercambia
                
                jugadores[0].classList.remove("intercambiarJugador");
                jugadores[1].classList.remove("intercambiarJugador");

                intercambiarJugadores(jugadores[0], jugadores[1]);
            }
        });

    }
}

function intercambiarJugadores(jugador, jugadorArrastrado) {

    // Recojo la clase de la posición de los dos jugadores
    let jugadorSoltado = jugadorArrastrado.classList[0];
    let jugadorTapado = jugador.classList[0];

    if (jugadorSoltado != jugadorTapado) { // Si son distintos, intercambio las clase de uno con el otro

        jugadorArrastrado.classList.remove(jugadorSoltado);
        jugador.classList.remove(jugadorTapado);

        jugador.classList.add(jugadorSoltado);
        jugadorArrastrado.classList.add(jugadorTapado);

        if (jugadorArrastrado.previousSibling == null) { // Si tiene no un hermano superior...

            // Cambia los divs de los jugadores añadiendo el div el primero al sginificar que no puede recoger el div anterior ya que es null
            hermanoJugador = jugadorArrastrado.nextSibling;
            jugador.parentNode.insertBefore(jugadorArrastrado, jugador.nextSibling);
            hermanoJugador.parentNode.insertBefore(jugador, hermanoJugador.parentNode.firstChild);

        } else { // Si tiene un hermano superior...

            if (jugadorArrastrado.previousSibling == jugador) { // si están uno al lado del oto
                
                jugador.parentNode.insertBefore(jugador, jugadorArrastrado.nextSibling); // inserto solo el jugador tapado después del jugador arrastrado

            } else { // Si no están juntos...

                // Intercambio los divs de uno por el otro
                hermanoJugador = jugadorArrastrado.previousSibling;
                jugador.parentNode.insertBefore(jugadorArrastrado, jugador.nextSibling);
                hermanoJugador.parentNode.insertBefore(jugador, hermanoJugador.nextSibling);
            }
            
        }
    }
}


/* Guardar jugadores */

function recogerJugadores(datosPlantilla, evento, accion, idPlantilla = "") {

    evento.preventDefault();
    let jugadores = document.querySelectorAll('.seccion_plantilla div[draggable]'); // Recojo todos los jugadores
    let posicionesJugadores = {};

    for (const jugador of jugadores) { // Recorro los jugadores y creo un array de clave valor con el id y la posición(la clase)

        let idJugador = jugador.getAttribute("data-idJugador");
        let posicion = jugador.getAttribute("class");
        posicionesJugadores[idJugador] = posicion;
    } 

    guardarJugadores(posicionesJugadores, datosPlantilla, accion, idPlantilla); 
}


function guardarJugadores(posicionesJugadores, datosPlantilla, accion, idPlantilla) {

    // Recojo los datos de la plantilla
    let tituloPlantilla = document.getElementById("titulo_plantilla").value;
    let formacion = document.getElementById("formacion").value;

    // Convierto a JSON los datos de la plantilla(datos de la API) y el array de posiciones
    posicionesJugadores = JSON.stringify(posicionesJugadores);
    datosPlantilla = JSON.stringify(datosPlantilla);

    // Datos de la consulta
    let ruta = "../controller/plantillas_guardar.php";
    let datos = {
        posicionesJugadores: posicionesJugadores,
        titulo: tituloPlantilla,
        formacion: formacion,
        datosPlantilla: datosPlantilla,
        accion: accion,
        idPlantilla: idPlantilla
    };

    let opciones = {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(datos)
    };

    return fetch(ruta, opciones) // Envío todos los datos
    .then(resultado => {

        if (resultado.redirected) { // Si la respuesta es una redirección significa que se creó la plantilla y reenvía a editar
            
            window.location.href = resultado.url;

        } else { // Si no hay redirección...
            
            return resultado.text().then(mensajeError => { // Añade el mensaje de que algo falló
                
                let seccionNegra = document.querySelector(".seccion_negra_fichajes");
                mostrarMensaje(seccionNegra, mensajeError); // Genera y muestra el párrafo

            });
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });

}

function escucharBotonesPopUp(idPlantilla) { // Si quiere eliminar la plantilla, se muestra el siguiente popUp para confirmar

    let mensajeBorrado = document.createElement("div");
    mensajeBorrado.classList.add("bloquearPagina");
    mensajeBorrado.id = "popUp_fuente";
    mensajeBorrado.innerHTML = "<div class='mensajeBorrado'>"+
        "<p>¿Seguro que quiere eliminar la plantilla?</p>"+
        "<div class='conjunto_botones'>" +
            "<button class='boton_rojo' id='cancelarBorrado'>Cancelar</button>" +
            "<button class='boton_verde' id='confirmarBorrado'>Confirmar</button>" +
        "</div></div>";

    // Agregar el elemento del mensaje de confirmación como hijo del cuerpo del documento
    document.body.appendChild(mensajeBorrado);

    escucharBotonesConfirmacion(idPlantilla); // Si se pulsa el botón de borrar escuchará el botón de confirmar y el de cancelar
}

function escucharBotonesConfirmacion(idPlantilla) {

    // Recojo los botones del popUp y el popUp
    let botonConfirmar = document.getElementById("confirmarBorrado");
    let botonCancelar = document.getElementById("cancelarBorrado");
    let divPopUp = document.querySelector(".bloquearPagina");

    botonConfirmar.addEventListener("click", () => { // Si pulsa en confirmar...

        divPopUp.remove(); // Se elimina el popUp

        fetch("../controller/plantillas_borrar.php?plantilla="+idPlantilla) // Se hace una consulta modificará los datos
        .then(resultado => {

            if (resultado.redirected) { // Si la respuesta es una redirección
        
                window.location.href = resultado.url;

            } else { // Si no hay redirección...

                let formulario = document.querySelector("form");
                mostrarMensaje(formulario, resultado);
            }
        })
        .catch(error => {
            // Manejo de errores
            console.error('Fetch error:', error);
        });

    });

    botonCancelar.addEventListener("click", () => { // Si pulsa en cancelar...

        divPopUp.remove(); // Se elimina el popUp
    });
}

function mostrarMensaje(elemento, mensaje) {
    
    let parrafoMensaje = document.createElement("p"); // Se crea un párrafo
    parrafoMensaje.setAttribute("class", "titulo_informacion"); // Se le añade la clase para los estilos
    parrafoMensaje.innerHTML = mensaje; // Se le añade un texto

    elemento.appendChild(parrafoMensaje); // Se añade el mensaje a la página
    
    setTimeout(function() {
        elemento.removeChild(parrafoMensaje); // A los 2 segundos se borra
    }, 2000); // 2000 milisegundos = 2 segundos
}

/* FUNCIONES EDITAR */
    
function comprobarEdicionPlantilla(datosPlantilla, idPlantilla) { // Se escucha si se quiere editar o borrar y se ejecuta lo apropiado

    let boton_editar = document.getElementById("editarEquipo");
    let boton_borrar = document.getElementById("borrarEquipo");

    boton_editar.addEventListener("click", (evento) => { recogerJugadores(datosPlantilla, evento, "editar", idPlantilla); });
    boton_borrar.addEventListener("click", (evento) => { 
        
        evento.preventDefault();
        escucharBotonesPopUp(idPlantilla) 
    });
}