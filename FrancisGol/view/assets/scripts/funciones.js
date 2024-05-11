function escucharCalendarios() {
    
    let inputCalendario = document.querySelectorAll(".inputCalendario");

    for (const calendario of inputCalendario) {
        
        calendario.addEventListener("input", () => {
          
            window.location.href = "../controller/partidos.php?fecha="+calendario.value;
        })

    }
}

function cambiarTablaDatos(datoEquipo) {
    
    let botonesEquipos = document.querySelectorAll(".botonEquipo");
    let datosEquipos = document.querySelectorAll(datoEquipo);

    botonesEquipos[0].addEventListener("click", () => {

        datosEquipos[0].classList.remove("ocultar");
        datosEquipos[1].classList.add("ocultar");

    })

    botonesEquipos[1].addEventListener("click", () => {

        datosEquipos[0].classList.add("ocultar");
        datosEquipos[1].classList.remove("ocultar");

    })
}
