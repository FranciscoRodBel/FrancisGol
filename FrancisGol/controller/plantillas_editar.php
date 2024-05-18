<?php
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";

    Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

    $titulo = "FrancisGol - Editar plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];

    $tituloPlantilla = "";
    $datosEquipo = "";
    $resultadoPlantilla = "<p class='parrafo_informacion'>No se encontró la plantilla.</p>"; // Si algún dato está vacío se muestra este mensaje

    if (isset($_GET['plantilla']) && !empty($_GET['plantilla'])) {  // Si se envía el id de la plantilla...
        
        $plantilla = Plantilla::recogerPlantilla($_GET['plantilla']); // Se crea el objeto de la plantilla

        if (!empty($plantilla)) {

            $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario de la sesión
            $idUsuario = $usuario->__get("id");

            if ($plantilla->__get("idUsuario") == $idUsuario) { // Si el id del usuario que tiene la sesión inciada es igual al propietario de la plantilla...

                // Recojo todos los datos de la plantilla para mostrarlo en sus inputs
                $tituloPlantilla = $plantilla->__get("titulo");
                $formacion = $plantilla->__get("formacion");
                $idPlantilla = $plantilla->__get("id");

                $equipo = Equipo::recogerEquipo($plantilla->__get("idEquipo")); // Se recoge el objeto del equipo

                if (!empty($equipo)) {

                    $datosEquipo = $equipo->pintarEquipo(); // HTML con el logo y nombre del equipo
                    $idEquipo = $equipo->__get("id");
                    $equipoPlantilla = json_decode($plantilla->__get("datosPlantilla")); // Recojo el json guardado en la BBDD
                    
                    if (!empty($equipoPlantilla)) {

                        $optionsSelectFormaciones = Plantilla::generarSelectFormaciones($formacion); // Se generan los options con las formaciones disponibles
                        $datosPlantilla = $plantilla->recogerDatosPlantilla(); // Recoge los jugadores y sus posiciones
                        $resultadoPlantilla = $plantilla->pintarPlantillaEditar($datosPlantilla); // Genera el HTML de las plantillas

                    } else {

                        $resultadoPlantilla = "<p class='parrafo_informacion'>No se puede editar en estos momentos.</p>";
                    }

                } else {

                    $resultadoPlantilla = "<p class='parrafo_informacion'>No se encontró el equipo.</p>";
                }

            } else { // Si no le pertenece envía al usuario a la página de mis plantillas

                header("Location: ../controller/plantillas_mis.php");
                die();
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_editar.php';
    include '../view/templates/footer.php';