function iniciarMenuHamburguesa() {

    let menuHamburguesa = document.getElementById("menu_hamburguesa"); // Selecciono el icono del menú

    menuHamburguesa.addEventListener("click", () => { // Si se hace click en el icono del menú
        
        menuHamburguesa.classList.toggle("menu_activado"); // Añado la clase que lo despliega
        document.getElementById("navegacion").classList.toggle("mostrar_nav");
    })
}
