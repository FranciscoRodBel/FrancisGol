function iniciarMenuHamburguesa() {

    let menuHamburguesa = document.getElementById("menu_hamburguesa");

    menuHamburguesa.addEventListener("click", () => {
        
        menuHamburguesa.classList.toggle("menu_activado");
        document.getElementById("navegacion").classList.toggle("mostrar_nav");
    })
}
