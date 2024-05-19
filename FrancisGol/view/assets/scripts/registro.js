function escucharFormularios() { // Se encarga de comprobar si algo cambia en el formulario
        
    let selectFoto = document.getElementById("seleccionar_foto");
    let foto_perfil = document.getElementById("foto_perfil");
    let inputFile = document.getElementById("inputFoto");
    let botonAnterior = document.querySelectorAll(".anterior");
    let botonSiguiente = document.querySelectorAll(".siguiente");
    let botonRegistro = document.getElementById("registro");

    for (const boton of botonAnterior) { // Si pulsa en anterior cambia la sección
        
        boton.addEventListener("click", (evento) => { cambiarSeccion(evento, "anterior") });
    }

    for (const boton of botonSiguiente) { // Si pulsa en siguiente cambia la sección
        
        boton.addEventListener("click", (evento) => { cambiarSeccion(evento, "siguiente") });
    }

    foto_perfil.addEventListener("click", (evento) => { // Si pulsa en la foto se abre el input
            
        evento.preventDefault();
        inputFile.click();

    });

    selectFoto.addEventListener("click", (evento) => { // Si pulsa en en el botón se abre el input
            
        evento.preventDefault();
        inputFile.click();

    });

    inputFile.addEventListener("change", () => {cambiarImagen(inputFile)}); // Coloca la imagen en pantalla

    botonRegistro.addEventListener("click", comprobarRegistro); // Si le da a registrarse realiza la comprobación

}

function cambiarSeccion(evento, accion) {
    
    let cambioSeccion;
    evento.preventDefault();
    section = evento.target.parentNode.parentNode; // Recojo la sección negra de la sección

    section.classList.toggle("desocultar"); // oculto/muestro la sección

    if (accion == "siguiente") { // Si pasa a la siguiente muestro la siguiente sección y oculta la anterior y viceversa

        cambioSeccion = section.nextElementSibling;

    } else {

        cambioSeccion = section.previousElementSibling;
    }

    cambioSeccion.classList.toggle("desocultar"); // oculto/muestro la sección
}

function cambiarImagen(inputFile) { // Recoge la foto 

    let fotoPerfil = document.getElementById("foto_perfil");

    if (inputFile.files.length > 0) { // Si está seleccionado en el input

        let archivo = inputFile.files[0]; // recoge la foto 
        
        if (esImagen(archivo)) { // Si es una imagen

            let urlImagen = URL.createObjectURL(archivo); // Crea la url

            fotoPerfil.src = urlImagen; // Lo añade al input 
        }
    }
}

function esImagen(archivo) { // recoge del nombre de la imagen la extensión final

    let extension = archivo.name.split('.').pop().toLowerCase();

    let extensionesPermitidas = ['jpg', 'jpeg', 'png']; 

    return extensionesPermitidas.includes(extension); // Si es una extensión válida devuelve true
}

function escucharFavoritosRegistro() { // Recojo los favoritos que va pulsando y los guardo en una variable global

    let estrellasFavorito = document.querySelectorAll(".icono_estrella");

    for (const estrella of estrellasFavorito) { // recorro todas las estrellas

        let idEstrella = estrella.id;
        let idEstrellaDivido = idEstrella.split('_');
        let accion = idEstrellaDivido[0];
        let id = idEstrellaDivido[1];

        if (favoritos[accion].includes(id)) { // Si la estrella está en el array la pinta de amarillo, esto sirve por si cambia de competición y vuelve se mantengan en amarillo las competiciones que había seleccionado

            estrella.classList.add("favorito");
        }

        estrella.removeEventListener("click", alPulsarEnEstrella); // Como se ejecuta cada vez que cambia de competición se elimina el listener
        estrella.addEventListener("click", alPulsarEnEstrella); // Lo añadirá o quitará de favoritos
    }
}

function alPulsarEnEstrella(evento) {

    evento.stopPropagation();
    evento.preventDefault();

    // Recojo los datos de la competición/equipo
    let idEstrella = evento.target.id;
    let idEstrellaDivido = idEstrella.split('_');
    let accion = idEstrellaDivido[0];
    let id = idEstrellaDivido[1];

    comprobarFavorito(evento.target, accion, id); // Realiza la acción de quitar o añadir favorito
}

function comprobarFavorito(estrella, accion, id) {

    let botonSiguiente = document.getElementById("competicion_seleccionada");
    let botonRegistro = document.getElementById("registro");

    if (estrella.classList.contains('favorito')) { // Si la estrella tiene la clase favorito, lo elimna de la variable global

        favoritos[accion].splice(favoritos[accion].indexOf(id), 1);

        if (accion == "competicion" && favoritos["competicion"].length == 0) { // Si no hay competiciones en favoritos oculta el botón para pasar a la siguiente sección
            
            botonSiguiente.classList.add("ocultar");

        } else if (accion == "equipo" && favoritos["equipo"].length == 0) { // Si no hay equipos en favoritos oculta el botón para registrarse
            
            botonRegistro.classList.add("ocultar");
        }

    } else { // Si la competición/equipo no está en favoritos

        favoritos[accion].push(id); // Lo añade en la variable global con clave valor: equipo/competicion => id

        if (accion == "competicion" && favoritos["competicion"].length > 0) { // Si añade competiciones en favoritos muestra el botón para pasar a la siguiente sección
            
            botonSiguiente.classList.remove("ocultar");

        } else if (accion == "equipo" && favoritos["equipo"].length > 0) { // Si añade equipos en favoritos muestra el botón para registrarse
            
            botonRegistro.classList.remove("ocultar");
        }
    }

    estrella.classList.toggle("favorito"); // Cambia el color de la estrella
}

function comprobarInputs() {
   
    let nombre = document.getElementById("nombre");
    let email = document.getElementById("email");
    let contrasenia = document.getElementById("contrasenia");
    let repetir_contrasenia = document.getElementById("repetir_contrasenia");

    // Escuchará los inputs del formulario y si no cumple con el pattern muestrará el mensaje al salir del input
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

    if (etiqueta.value.trim().length != 0) { // Si no está vacío el input...

        if (etiqueta.nextElementSibling.tagName == "P") { // Recojo los párrafos...
            etiqueta.nextElementSibling.remove(); // Y los elimino
        }

        if (expresion.test(etiqueta.value)) { // Si cumple el pattern

            etiqueta.classList.remove("inputIncorrecto"); // elimina la clase inputIncorrecto para que no muestre el borde rojo

        } else { // si no cumple el pattern

            etiqueta.classList.add("inputIncorrecto"); // Añade la clase
            
            let parrafo = document.createElement("p"); // Creo el párrafo con el mensaje de error y lo añado después del input
            parrafo.setAttribute("class","mensaje_error");
            parrafo.innerHTML = mensaje;
            etiqueta.parentNode.insertBefore(parrafo, etiqueta.nextSibling);

        }
        
    } else { // Si hay espacios los elimina

        etiqueta.value = ""; 
    }
}

function mostrarOcultarContrasenia() {
    
    let iconosOjos = document.querySelectorAll(".ojo_contrasenia");

    for (const icono of iconosOjos) { // Recorro los iconos de los ojos 
        
        icono.addEventListener("click", () => {mostrarContrasenia(icono)}); // si pulsa en uno cambio el tipo de input
    }
}

function mostrarContrasenia(icono) { // Si tiene el tipo password pongo el text y viceversa
        
    if (icono.nextElementSibling.type == "password") { 

        icono.nextElementSibling.type = "text";

    } else {

        icono.nextElementSibling.type = "password";
    }
    
}

function comprobarRegistro(event) { // si pulsa en registrarse...
    
    event.preventDefault();

    let parrafoResultado = document.getElementById("resultado_formulario");
    let formulario = document.querySelector("form");

    let formData = new FormData(formulario); // Creo un objeto para enviar los datos por post

    formData.append('favoritos', JSON.stringify(favoritos)); // Añado al objeto el array con los equipos/competiciones en formato JSON

    let opcionesFetch = {
        method: 'POST',
        body: formData
    };

    parrafoResultado.innerHTML = "<div class='cargando'></div>"; // Añado el icono de carga

    fetch(formulario.getAttribute('action'), opcionesFetch)
    .then(resultado => resultado.text())
    .then(respuesta => { // Cuando termine el registro mostrará el error o la creación de la cuenta eliminando el icono de carga

        parrafoResultado.innerHTML = respuesta;

    })
    .catch(error => {
        console.error('Error:', error);
    });
}

/* FUNCIONES EDITAR CUENTA */

function comprobarInputsEditar() {
    
    let nuevaContrasenia = document.getElementById("nueva_contrasenia");
    let contraseniaActual = document.getElementById("contrasenia_actual");
    let boton_borrar = document.getElementById("borrarCuenta");

    // Escucho los inputs y si salen de uno compruebo si cumple el pattern
    nuevaContrasenia.addEventListener("blur", function () {
        comprobarAlSalirDelInput(nuevaContrasenia, /(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)^[\w\W]{8,50}$/, "Debe incluir una mayúscula, minúscula, número y un caracter extraño entre 8 y 50 caracteres.");
    })

    contraseniaActual.addEventListener("blur", function () {
        comprobarAlSalirDelInput(contraseniaActual, /(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)^[\w\W]{8,50}$/, "Debe incluir una mayúscula, minúscula, número y un caracter extraño entre 8 y 50 caracteres.");
    })

    boton_borrar.addEventListener("click", (evento) => { // Escucho si pulsa en borrar cuenta
        
        evento.preventDefault();
        escucharBotonesPopUpCuenta() 
    });
}

function escucharFormulariosEditar() {
        
    let selectFoto = document.getElementById("seleccionar_foto");
    let foto_perfil = document.getElementById("foto_perfil");
    let inputFile = document.getElementById("inputFoto");
    let botonEditarFoto = document.getElementById("editarFoto");
    let botonEditarDatos = document.getElementById("editarDatos");
    let editarContrasenia = document.getElementById("editarContrasenia");

    foto_perfil.addEventListener("click", (evento) => { // Si pulsa en la foto se abre el input file
            
        evento.preventDefault();
        inputFile.click();

    });
    selectFoto.addEventListener("click", (evento) => { // Si pulsa en en el botón se abre el input file
            
        evento.preventDefault();
        inputFile.click();

    });

    inputFile.addEventListener("change", () => {cambiarImagen(inputFile)});

    // Compruebo si edita algún valor
    botonEditarFoto.addEventListener("click", comprobarEdicion);
    botonEditarDatos.addEventListener("click", comprobarEdicion);
    editarContrasenia.addEventListener("click", comprobarEdicion);

}

function comprobarEdicion(event) { // La diferencia con la del registro es que aquí no se guardan los favoritos
    
    event.preventDefault();

        // Si pulsa en editar recojo los datos y los guardo en un objeto para enviarlo por POST
    let parrafoResultado = event.target.nextElementSibling;
    let formulario = event.target.parentNode;

    let formData = new FormData(formulario);

    let opcionesFetch = {
        method: 'POST',
        body: formData
    };

    parrafoResultado.innerHTML = "<div class='cargando'></div>"; // añado el icono de carga

    fetch(formulario.getAttribute('action'), opcionesFetch)
    .then(resultado => resultado.text())
    .then(respuesta => { // Cuando termine el registro mostrará el error o la edición de la cuenta eliminando el icono de carga

        parrafoResultado.innerHTML = respuesta;

    })
    .catch(error => {
        console.error('Error:', error);
    });
}


function escucharBotonesPopUpCuenta() { // mostrará un mensaje para confirmar si queire borrar la cuenta

    let mensajeBorrado = document.createElement("div");
    mensajeBorrado.classList.add("bloquearPagina");
    mensajeBorrado.id = "popUp_fuente";
    mensajeBorrado.innerHTML = "<div class='mensajeBorrado'>"+
        "<p>¿Seguro que quiere eliminar la cuenta?</p>"+
        "<p>Esta acción no se podrá revertir.</p>"+
        "<div class='conjunto_botones'>" +
            "<button class='boton_rojo' id='cancelarBorrado'>Cancelar</button>" +
            "<button class='boton_verde' id='confirmarBorrado'>Confirmar</button>" +
        "</div></div>";

    // Agregar el elemento del mensaje de confirmación como hijo del cuerpo del documento
    document.body.appendChild(mensajeBorrado);

    escucharBotonesConfirmacionCuenta(); // Si se pulsa el botón de borrar escuchará el botón de confirmar y el de cancelar
}

function escucharBotonesConfirmacionCuenta() {

    // Recojo los botones del popUp y el popUp
    let botonConfirmar = document.getElementById("confirmarBorrado");
    let botonCancelar = document.getElementById("cancelarBorrado");
    let divPopUp = document.querySelector(".bloquearPagina");

    botonConfirmar.addEventListener("click", () => { // Si pulsa en confirmar...

        divPopUp.remove(); // Se elimina el popUp

        fetch("../controller/cuenta_borrar.php") // Se hace una consulta modificará los datos
        .then(response => response.text())
        .then(resultado => {

            if (resultado.redirected) { // Si la respuesta es una redirección
        
                window.location.href = resultado.url;

            } else { // Si no hay redirección...

                let seccion = document.querySelector(".seccionBorrarCuenta");
                mostrarMensaje(seccion, resultado);
                seccion.lastElementChild.setAttribute("class","titulo_informacion_negro")
            }

        })
        .catch(error => {
            // Manejo de errores
            console.error('Fetch error:', error);
        });

    });

    botonCancelar.addEventListener("click", () => { // Si pulsa en cancelar...

        divPopUp.remove(); // Se elimina el popUp
    });
}


/* INICIO DE SESIÓN */

function inicioSesion() { // Escuchará si se puslsa en iniciar sesión

    let botonInicio = document.getElementById("iniciarSesion");

    botonInicio.addEventListener("click", comprobarInicio);
}

function comprobarInicio(evento) { // Enviará los datos del inicio de sesión para comprobar si son correctos

    evento.preventDefault();

    let parrafoResultado = document.getElementById("resultado_formulario");
    let formulario = document.querySelector("form");

    let formData = new FormData(formulario);

    let opcionesFetch = {
        method: 'POST',
        body: formData
    };

    parrafoResultado.innerHTML = "<div class='cargando'></div>"; // Añade el icono de carga

    fetch(formulario.getAttribute('action'), opcionesFetch)
    .then(resultado => resultado.text())
    .then(respuesta => {

        if (respuesta.length == 0) { // Si devuelve vacío es que se inició sesión por tanto te envía la página principal
            
            window.location.href = "../controller/partidos.php";

        } else {  // si no está vacío es que devolvió un mensaje de error

            parrafoResultado.innerHTML = respuesta;
        }

    })
    .catch(error => {
        console.error('Error:', error);
    });
}