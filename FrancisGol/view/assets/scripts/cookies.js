function escucharCookies() { // Si el usuario inicia sesión y no tiene las cookies aceptadas se incia esta función

    let botonAceptar = document.getElementById("aceptarCookies");
    let botonRechazar = document.getElementById("rechazarCookies");
    let seccionCookie = document.getElementById("seccionCookies");

    if (botonAceptar && botonRechazar && seccionCookie) { // Si existen los botones

        botonAceptar.addEventListener("click", () => { // Si pulsa en aceptar acepta las cookies y elimino el mensaje
            comprobarCookies("aceptar");
            seccionCookie.remove();
        });

        botonRechazar.addEventListener("click", () => { // Si pulsa en rechazar acepta las cookies y elimino el mensaje
            comprobarCookies("rechazar");
            seccionCookie.remove();
        });
    }
}

function comprobarCookies(accion) { // Se realizará la consulta para aceptar o rechazar la cookie

    fetch("../controller/comprobarCookies.php?accion="+accion)
    .then(resultado => {})
    .catch(error => {
        console.error('Fetch error:', error); // Manejo de errores
    });
}