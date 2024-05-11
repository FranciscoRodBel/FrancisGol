function escucharCalendarios() {
    
    let inputCalendario = document.querySelectorAll(".inputCalendario");

    for (const calendario of inputCalendario) {
        
        calendario.addEventListener("input", () => {
          
            window.location.href = "../controller/partidos.php?fecha="+calendario.value;
        })

    }
}