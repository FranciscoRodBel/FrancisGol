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

                seleccionarDatos("#competiciones2", "../controller/seleccionar_equipos.php", '#equipos_competicion', false);
            }

            try { // Si la primera función existe es que se está en otra página diferente de la del registro
                escucharFavoritos();

            } catch (error) { // Si da error es que se está en el registro y se selecciona la siguiente función

                escucharFavoritosRegistro();
            }

        }
    });
}

function seleccionarCompeticiones() { // Esta función sirve para cuando son 2 selects pais y comeptición, equipo se muestra con html para dar favorito
    // La idea de la función es que si se cambia un pais se cambie la competición y si se cambia la competición se cambie el equipo, funciona para 2 tipos de formularios los que tiene el select de equipos y los que no
    
    let pais1 = document.getElementById("seleccionar_pais1");
    let pais2 = document.getElementById("seleccionar_pais2");
    let competiciones2 = document.getElementById("competiciones2");

    // Lo ejecuta al principio para que al inciar la página ya estén seleccionados los selects
    seleccionarDatos("#seleccionar_pais1", "../controller/seleccionar_competiciones.php", '#competiciones', false);
    seleccionarDatos("#seleccionar_pais2", "../controller/seleccionar_competiciones2.php", '#competiciones2', true);

    pais1.addEventListener("change", () => { // Comprueba si cambia el pais del primer formulario

        seleccionarDatos("#seleccionar_pais1", "../controller/seleccionar_competiciones.php", '#competiciones', false);
    });

    pais2.addEventListener("change", () => { // Comprueba si cambia el pais del segundo formulario 

        seleccionarDatos("#seleccionar_pais2", "../controller/seleccionar_competiciones2.php", '#competiciones2', true);

    });

    competiciones2.addEventListener("change", () => { // Comprueba si cambia la competición del segundo formulario

        seleccionarDatos("#competiciones2", "../controller/seleccionar_equipos.php", '#equipos_competicion', false);
    });
    
}