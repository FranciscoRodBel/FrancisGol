function escucharFavoritos() {
    
    let estrellasFavorito = document.querySelectorAll(".icono_estrella");

    for (const estrella of estrellasFavorito) {
        
        estrella.addEventListener("click", (evento) => {

            evento.stopPropagation();
            evento.preventDefault();
            
            let idEstrella = estrella.id;
            let idEstrellaDivido = idEstrella.split('_');
            let accion = idEstrellaDivido[0];
            let id = idEstrellaDivido[1];

            if (estrella.classList.contains('favorito')) {

                fetch("../controller/favorito_quitar.php?accion="+accion+"&id="+id)
                .then(resultado => resultado.text())
                .then(resultado => {

                    resultado != "" ? estrella.classList.toggle("favorito") : "";

                })
                .catch(error => {
                    
                    console.error('Fetch error:', error); // Manejo de errores
                });

            } else {

                fetch("../controller/favorito_insertar.php?accion="+accion+"&id="+id)
                .catch(error => {
                    
                    console.error('Fetch error:', error); // Manejo de errores
                });
                estrella.classList.toggle("favorito");

            }
        });
    }
}