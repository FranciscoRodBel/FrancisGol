function seleccionarDatos(selectFormulario, rutaController, divPintarDatos, condicion) {

    let idPais = $(selectFormulario).val();
    $.ajax({
        url: rutaController,
        method: 'POST',
        data: {
            query: idPais
        },
        success: function(datos) {
            $(divPintarDatos).html(datos);
            
            
            if (condicion) { // Si envía true selecciona los equipos de las competiciones, se usa cuando se selecciona un país que selecciona una comeptición que selecciona un equipo

                seleccionarDatos("#competiciones", "../controller/seleccionar_equipos2.php", '#equipos_competicion', false);

            }
        }
    });
}

function seleccionarCompeticionesEquipos() { // Esta función sirve para cuando son 3 selects pais, comeptición y equipo
    
    let pais = document.getElementById("seleccionar_pais");
    let competiciones = document.getElementById("competiciones");

    seleccionarDatos("#seleccionar_pais", "../controller/seleccionar_competiciones2.php", '#competiciones', true);

    pais.addEventListener("change", () => { // Comprueba si cambia el pais del formulario

        seleccionarDatos("#seleccionar_pais", "../controller/seleccionar_competiciones2.php", '#competiciones', true);
    });

    competiciones.addEventListener("change", () => { // Comprueba si cambia la competición del formulario

        seleccionarDatos("#competiciones", "../controller/seleccionar_equipos2.php", '#equipos_competicion', true);
    });
}

function escucharSelectEquiposFavoritos() { // Si cambia el select de equipos favoritos en la página de fichajes actualiza los fichajes del equipo 
    
    let selectEquipo = document.getElementById("seleccion_equipo");
    recogerFichajes(selectEquipo);

    selectEquipo.addEventListener("change", (evento) => { recogerFichajes(evento.target) });
}

function recogerFichajes(selectEquipo) { // Realiza la consulta para recoger los fichajes de un equipo y añadirlos en la página

    let idEquipo = selectEquipo.value;
    let sectionFichajes = document.getElementById("fichajes_equipos_favoritos");

    fetch('../controller/seleccionar_fichajes.php?equipo=' + idEquipo)
    .then(resultado => resultado.text())
    .then(fichajes => {
        
        sectionFichajes.innerHTML = fichajes;
    })
    .catch(error => {
        console.error('Error:', error);
    });
}