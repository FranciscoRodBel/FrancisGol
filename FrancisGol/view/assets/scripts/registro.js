function escucharFormularios() {
        
    let selectFoto = document.getElementById("seleccionar_foto");
    let inputFile = document.getElementById("inputFoto");
    let botonAnterior = document.querySelectorAll(".anterior");
    let botonSiguiente = document.querySelectorAll(".siguiente");

    for (const boton of botonAnterior) {
        
        boton.addEventListener("click", (evento) => { cambiarSeccion(evento, "anterior") });
    }

    for (const boton of botonSiguiente) {
        
        boton.addEventListener("click", (evento) => { cambiarSeccion(evento, "siguiente") });
    }

    selectFoto.addEventListener("click", (evento) => {
            
        evento.preventDefault();
        inputFile.click();

    });

    inputFile.addEventListener("change", () => {cambiarImagen(inputFile)});

}

function cambiarSeccion(evento, accion) {
    
    let cambioSeccion;
    evento.preventDefault();
    section = evento.target.parentNode.parentNode;

    section.classList.toggle("desocultar");

    if (accion == "siguiente") {
        cambioSeccion = section.nextElementSibling;
    } else {
        cambioSeccion = section.previousElementSibling;
    }

    cambioSeccion.classList.toggle("desocultar");
}

function cambiarImagen(inputFile) {

    let fotoPerfil = document.getElementById("foto_perfil");

    if (inputFile.files.length > 0) {

        let archivo = inputFile.files[0];
        
        if (esImagen(archivo)) {

            let urlImagen = URL.createObjectURL(archivo);

            fotoPerfil.src = urlImagen;
        }
    }
}

function esImagen(archivo) {

    let extension = archivo.name.split('.').pop().toLowerCase();

    let extensionesPermitidas = ['jpg', 'jpeg', 'png', 'gif'];

    return extensionesPermitidas.includes(extension);
}