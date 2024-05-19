function escucharFavoritos() { 
    
    let estrellasFavorito = document.querySelectorAll(".icono_estrella");

    for (const estrella of estrellasFavorito) { // Si pulsa en una estrella actualiza el estado
        
        estrella.removeEventListener("click", cambiarFavorito); // Se elimina el listener porque esta función se llama varias veces en una página y si no se elimina puede crear errores
        estrella.addEventListener("click", cambiarFavorito);
    }
}

function cambiarFavorito(evento) {
    
    evento.stopPropagation(); // esto es para que al pulsar en la estrella no envíe a un enlace que esté por encima en el HTML
    evento.preventDefault();

    // Recojo el id de la estrella que tendrá equipo/competición y el id
    let estrella = evento.target;
    let idEstrella = evento.target.id;
    let idEstrellaDivido = idEstrella.split('_');
    let accion = idEstrellaDivido[0];
    let id = idEstrellaDivido[1];

    if (estrella.classList.contains('favorito')) { // si tiene la clase favorito lo elimina

        fetch("../controller/favorito_quitar.php?accion="+accion+"&id="+id)
        .then(resultado => resultado.text())
        .then(resultado => {

            resultado != "" ? estrella.classList.toggle("favorito") : ""; // Si devuelve vacío significa que no se borró porque solo hay una competición/equipo en la BBDD y como mínimo tiene que haber 1

        })
        .catch(error => {
            
            console.error('Fetch error:', error); // Manejo de errores
        });

    } else { // Si no tiene la clase favorito lo inserta

        fetch("../controller/favorito_insertar.php?accion="+accion+"&id="+id)
        .catch(error => {
            
            console.error('Fetch error:', error); // Manejo de errores
        });
        estrella.classList.toggle("favorito"); // Se añade la clase para que se marque como favorito

    }

}