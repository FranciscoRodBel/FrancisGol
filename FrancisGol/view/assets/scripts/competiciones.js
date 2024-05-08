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
            
            if (condicion) {

                seleccionarDatos("#competiciones2", "../controller/seleccionar_equipos.php", '#equipos_competicion', false);
            }
            escucharFavoritosRegistro();
        }
    });
}

function seleccionarCompeticiones() {
    
    let pais1 = document.getElementById("seleccionar_pais1");
    let pais2 = document.getElementById("seleccionar_pais2");
    let competiciones2 = document.getElementById("competiciones2");

    seleccionarDatos("#seleccionar_pais1", "../controller/seleccionar_competiciones.php", '#competiciones', false);
    seleccionarDatos("#seleccionar_pais2", "../controller/seleccionar_competiciones2.php", '#competiciones2', true);

    pais1.addEventListener("change", () => {

        seleccionarDatos("#seleccionar_pais1", "../controller/seleccionar_competiciones.php", '#competiciones', false);
    });

    pais2.addEventListener("change", () => {

        seleccionarDatos("#seleccionar_pais2", "../controller/seleccionar_competiciones2.php", '#competiciones2', true);

    });

    competiciones2.addEventListener("change", () => {

        seleccionarDatos("#competiciones2", "../controller/seleccionar_equipos.php", '#equipos_competicion', false);
    });
    
}