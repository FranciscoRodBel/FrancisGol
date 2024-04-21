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

                seleccionarDatos("#competiciones", "../controller/seleccionar_equipos2.php", '#equipos_competicion', false);

            }

        }
    });
}

function seleccionarCompeticionesEquipos() {
    
    let pais = document.getElementById("seleccionar_pais");
    let competiciones = document.getElementById("competiciones");

    seleccionarDatos("#seleccionar_pais", "../controller/seleccionar_competiciones2.php", '#competiciones', true);

    pais.addEventListener("change", () => {

        seleccionarDatos("#seleccionar_pais", "../controller/seleccionar_competiciones2.php", '#competiciones', true);
    });

    competiciones.addEventListener("change", () => {

        seleccionarDatos("#competiciones", "../controller/seleccionar_equipos2.php", '#equipos_competicion', true);
    });
}