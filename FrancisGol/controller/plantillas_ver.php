<?php
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Ver plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];

    $nombreUsuario = "";
    $tituloPlantilla = "";
    $datosEquipo = "";
    $formacion = "";
    $resultadoPlantilla = "<p>No se encontró la plantilla.</p>"; // Si algún dato está vacío se muestra este mensaje

    if (isset($_GET['plantilla']) && !empty($_GET['plantilla'])) { // Si se envía el id de la plantilla...
        
        $plantilla = Plantilla::recogerPlantilla($_GET['plantilla']); // Se recoge el objeto del equipo
        
        if (!empty($plantilla)) {

            // Recojo los datos del usuario para mostrarlos
            $nombreUsuario = Usuario::recogerNombreUsuario($plantilla->__get("idUsuario")); // Recojo el nombre del propietario de la plantilla
            $tituloPlantilla = $plantilla->__get("titulo");
            $formacion = $plantilla->__get("formacion");
            
            $equipo = Equipo::recogerEquipo($plantilla->__get("idEquipo")); // Se recoge el objeto del equipo

            if (!empty($equipo)) {

                $datosEquipo = $equipo->pintarEquipo(); // HTML con el logo y nombre del equipo
                $idEquipo = $equipo->__get("id");
                
                $equipoPlantilla = json_decode($plantilla->__get("datosPlantilla")); // Recojo el json guardado en la BBDD
                
                if (!empty($equipoPlantilla)) {

                    $datosPlantilla = $plantilla->recogerDatosPlantilla(); // Recoge los jugadores y sus posiciones
                    $resultadoPlantilla = $plantilla->pintarPlantillaEditar($datosPlantilla); // Genera el HTML de las plantillas
                }
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_ver.php';
    include '../view/templates/footer.php';
