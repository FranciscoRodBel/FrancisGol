function escucharFormularios() {
        
    let selectFoto = document.getElementById("seleccionar_foto");
    let foto_perfil = document.getElementById("foto_perfil");
    let inputFile = document.getElementById("inputFoto");
    let botonAnterior = document.querySelectorAll(".anterior");
    let botonSiguiente = document.querySelectorAll(".siguiente");
    let botonRegistro = document.getElementById("registro");

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

    botonRegistro.addEventListener("click", comprobarRegistro);

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

    let botonSiguiente = document.getElementById("competicion_seleccionada");
    let botonRegistro = document.getElementById("registro");

    if (estrella.classList.contains('favorito')) {

        favoritos[accion].splice(favoritos[accion].indexOf(id), 1);

        if (accion == "competicion" && favoritos["competicion"].length == 0) {
            
            botonSiguiente.classList.add("ocultar");

        } else if (accion == "equipo" && favoritos["equipo"].length == 0) {
            
            botonRegistro.classList.add("ocultar");
        }
    } else {

        favoritos[accion].push(id);

        if (accion == "competicion" && favoritos["competicion"].length > 0) {
            
            botonSiguiente.classList.remove("ocultar");

        } else if (accion == "equipo" && favoritos["equipo"].length > 0) {
            
            botonRegistro.classList.remove("ocultar");
        }
    }

    estrella.classList.toggle("favorito");
}

function comprobarInputs() {
   
    let nombre = document.getElementById("nombre");
    let email = document.getElementById("email");
    let contrasenia = document.getElementById("contrasenia");
    let repetir_contrasenia = document.getElementById("repetir_contrasenia");

    nombre.addEventListener("blur", function () {
        comprobarAlSalirDelInput(nombre, /(?=.*[a-zA-Z].*)^[\w.]{5,25}$/i, "Debe incluir letras, números, puntos o guiones bajos entre 5 y 25 caracteres.");
    })

    email.addEventListener("blur", function () {
        comprobarAlSalirDelInput(email, /(?=^.{5,70}$)[\w]+@[\w]+\.[\w]+/i, "Debe incluir letras, números o guiones bajos entre 5 y 70 caracteres");
    })

    contrasenia.addEventListener("blur", function () {
        comprobarAlSalirDelInput(contrasenia, /(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)^[\w\W]{8,50}$/, "Debe incluir una mayúscula, minúscula, número y un caracter extraño entre 8 y 50 caracteres.");
    })

    repetir_contrasenia.addEventListener("blur", function () {
        comprobarAlSalirDelInput(repetir_contrasenia, /(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)^[\w\W]{8,50}$/, "Debe incluir una mayúscula, minúscula, número y un caracter extraño entre 8 y 50 caracteres.");
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

        etiqueta.value = ""; 
    }
}

function mostrarOcultarContrasenia() {
    
    let iconosOjos = document.querySelectorAll(".ojo_contrasenia");

    for (const icono of iconosOjos) {
        
        icono.addEventListener("click", () => {mostrarContrasenia(icono)});
    }
}

function mostrarContrasenia(icono) {
        
    if (icono.nextElementSibling.type == "password") {

        icono.nextElementSibling.type = "text";

    } else {

        icono.nextElementSibling.type = "password";
    }
    
}

function comprobarRegistro(event) {
    
    event.preventDefault();

    let parrafoResultado = document.getElementById("resultado_formulario");
    let formulario = document.querySelector("form");

    let formData = new FormData(formulario);

    formData.append('favoritos', JSON.stringify(favoritos));

    let opcionesFetch = {
        method: 'POST',
        body: formData
    };

    parrafoResultado.innerHTML = "<div class='cargando'></div>";

    fetch(formulario.getAttribute('action'), opcionesFetch)
    .then(resultado => resultado.text())
    .then(respuesta => {

        parrafoResultado.innerHTML = respuesta;

    })
    .catch(error => {
        console.error('Error:', error);
    });
}

/* Funciones editar cuenta */

function comprobarInputsEditar() {
    
    let nuevaContrasenia = document.getElementById("nueva_contrasenia");
    let contraseniaActual = document.getElementById("contrasenia_actual");

    nuevaContrasenia.addEventListener("blur", function () {
        comprobarAlSalirDelInput(nuevaContrasenia, /(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)^[\w\W]{8,50}$/, "Debe incluir una mayúscula, minúscula, número y un caracter extraño entre 8 y 50 caracteres.");
    })

    contraseniaActual.addEventListener("blur", function () {
        comprobarAlSalirDelInput(contraseniaActual, /(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)^[\w\W]{8,50}$/, "Debe incluir una mayúscula, minúscula, número y un caracter extraño entre 8 y 50 caracteres.");
    })
}

function escucharFormulariosEditar() {
        
    let selectFoto = document.getElementById("seleccionar_foto");
    let foto_perfil = document.getElementById("foto_perfil");
    let inputFile = document.getElementById("inputFoto");
    let botonEditarFoto = document.getElementById("editarFoto");
    let botonEditarDatos = document.getElementById("editarDatos");
    let editarContrasenia = document.getElementById("editarContrasenia");

    foto_perfil.addEventListener("click", (evento) => {
            
        evento.preventDefault();
        inputFile.click();

    });
    selectFoto.addEventListener("click", (evento) => {
            
        evento.preventDefault();
        inputFile.click();

    });

    inputFile.addEventListener("change", () => {cambiarImagen(inputFile)});

    botonEditarFoto.addEventListener("click", comprobarEdicion);
    botonEditarDatos.addEventListener("click", comprobarEdicion);
    editarContrasenia.addEventListener("click", comprobarEdicion);

}

function comprobarEdicion(event) {
    
    event.preventDefault();

    let parrafoResultado = event.target.nextElementSibling;
    let formulario = event.target.parentNode;


    let formData = new FormData(formulario);

    let opcionesFetch = {
        method: 'POST',
        body: formData
    };

    parrafoResultado.innerHTML = "<div class='cargando'></div>";

    fetch(formulario.getAttribute('action'), opcionesFetch)
    .then(resultado => resultado.text())
    .then(respuesta => {

        parrafoResultado.innerHTML = respuesta;

    })
    .catch(error => {
        console.error('Error:', error);
    });
}