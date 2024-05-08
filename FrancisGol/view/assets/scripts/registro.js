function escucharFormularios() {
        
    let selectFoto = document.getElementById("seleccionar_foto");
    let foto_perfil = document.getElementById("foto_perfil");
    let inputFile = document.getElementById("inputFoto");
    let botonAnterior = document.querySelectorAll(".anterior");
    let botonSiguiente = document.querySelectorAll(".siguiente");

    for (const boton of botonAnterior) {
        
        boton.addEventListener("click", (evento) => { cambiarSeccion(evento, "anterior") });
    }

    for (const boton of botonSiguiente) {
        
        boton.addEventListener("click", (evento) => { cambiarSeccion(evento, "siguiente") });
    }


    foto_perfil.addEventListener("click", (evento) => {
            
        evento.preventDefault();
        inputFile.click();

    });
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

function escucharFavoritosRegistro() {

    let estrellasFavorito = document.querySelectorAll(".icono_estrella");

    for (const estrella of estrellasFavorito) {

        let idEstrella = estrella.id;
        let idEstrellaDivido = idEstrella.split('_');
        let accion = idEstrellaDivido[0];
        let id = idEstrellaDivido[1];

        if (favoritos[accion].includes(id)) {

            estrella.classList.add("favorito");
        }

        estrella.removeEventListener("click", alPulsarEnEstrella);
        estrella.addEventListener("click", alPulsarEnEstrella);
    }
}

function alPulsarEnEstrella(evento) {

    evento.stopPropagation();
    evento.preventDefault();

    let idEstrella = evento.target.id;
    let idEstrellaDivido = idEstrella.split('_');
    let accion = idEstrellaDivido[0];
    let id = idEstrellaDivido[1];

    comprobarFavorito(evento.target, accion, id);
}

function comprobarFavorito(estrella, accion, id) {

    if (estrella.classList.contains('favorito')) {

        favoritos[accion].splice(favoritos[accion].indexOf(id), 1);
    } else {

        favoritos[accion].push(id);
    }

    estrella.classList.toggle("favorito");
}

function comprobarInputs() {
   
    let nombre = document.getElementById("nombre");
    let email = document.getElementById("email");
    let contrasenia = document.getElementById("contrasenia");
    let repetir_contrasenia = document.getElementById("repetir_contrasenia");

    nombre.addEventListener("blur", function () {
        comprobarAlSalirDelInput(nombre, /^[\w.]{5,25}$/, "El nombre tiene que estar compuesto por letras, números, puntos o guiones bajos entre 5 y 25 caracteres.");
    })

    email.addEventListener("blur", function () {
        comprobarAlSalirDelInput(email, /^[\w.]{5,25}$/, "hola");
    })

    contrasenia.addEventListener("blur", function () {
        comprobarAlSalirDelInput(email, /^[\w.]{5,25}$/, "hola");
    })

    repetir_contrasenia.addEventListener("blur", function () {
        comprobarAlSalirDelInput(email, /^[\w.]{5,25}$/, "hola");
    })
    
}

function comprobarAlSalirDelInput(etiqueta, expresion, mensaje) {

    if (etiqueta.value.trim().length != 0) {

        if (etiqueta.nextElementSibling.tagName == "P") {
            etiqueta.nextElementSibling.remove();
        }

        if (expresion.test(etiqueta.value)) {

            etiqueta.classList.remove("inputIncorrecto");

        } else {

            etiqueta.classList.add("inputIncorrecto");
            
            let parrafo = document.createElement("p");
            parrafo.setAttribute("class","mensaje_error");
            parrafo.innerHTML = mensaje;
            etiqueta.parentNode.insertBefore(parrafo, etiqueta.nextSibling);

        }
        

    } else {
        nombre.value = ""; 
    }
}
