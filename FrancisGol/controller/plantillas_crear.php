<?php
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Crear plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];
    $plantilla = "<p class='parrafo_informacion'>Debe iniciar sesión para crear plantillas.</p>"; // Si algún dato está vacío se muestra este mensaje
    $datosEquipo = "";

    if (isset($_SESSION['usuario'])) { // Si el usuario inicia sesión
        
        $paises = crearOpcionesPaises(); // Se generan las opciones para el select que se utiliza para seleccionar las competiciones

        if (isset($_POST['enviarEquipo']) && isset($_POST['equipos_competicion']) && !empty($_POST['equipos_competicion'])) { // Si se envía el id del equipo
            
            $idEquipo = $_POST['equipos_competicion'];
            $equipo = Equipo::recogerEquipo($idEquipo); // Se recoge el objeto del equipo

            if (!empty($equipo)) {

                $datosEquipo = $equipo->pintarEquipo(); // HTML con el logo y nombre del equipo
                $optionsSelectFormaciones = Plantilla::generarSelectFormaciones(); // Se generan los options con las formaciones disponibles
                $equipoPlantilla = realizarConsulta("equipo_plantilla_$idEquipo", "/players/squads?team=$idEquipo", 604800); // Recojo la plantilla actual del equipo cada semana
                $plantilla = Plantilla::generarPlantilla($equipoPlantilla); // Genera el HTML con la alineación, sustitutos y reservas

            } else {
                
                $plantilla = "<p class='parrafo_informacion'>No se encontró el equipo.</p>";
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_crear.php';
    include '../view/templates/footer.php';