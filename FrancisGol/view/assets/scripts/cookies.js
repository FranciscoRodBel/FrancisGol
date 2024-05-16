function escucharCookies() {
    let botonAceptar = document.getElementById("aceptarCookies");
    let botonRechazar = document.getElementById("rechazarCookies");
    let seccionCookie = document.getElementById("seccionCookies");

    if (botonAceptar && botonRechazar && seccionCookie) {

        botonAceptar.addEventListener("click", () => {
            comprobarCookies("aceptar");
            seccionCookie.remove();
        });

        botonRechazar.addEventListener("click", () => {
            comprobarCookies("rechazar");
            seccionCookie.remove();
        });
    }
}

function comprobarCookies(accion) {

    fetch("../controller/comprobarCookies.php?accion="+accion)
    .then(resultado => {})
    .catch(error => {
        console.error('Fetch error:', error); // Manejo de errores
    });
}