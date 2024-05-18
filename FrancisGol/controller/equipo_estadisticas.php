<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Equipo estadísticas";
    $lista_css = ["competiciones.css"];

    $opcionesCompeticiones = "";
    $opcionesAnios = "";
    $datosEquipo = "<p class='parrafo_informacion_blanco'>Equipo no encontrado.</p>";  // Si algún dato está vacío se muestra este mensaje

    if (isset($_GET["equipo"]) && !empty($_GET["equipo"])) { // Si se ha enviado el id del equipo

        $idEquipo = $_GET["equipo"];
        $equipo = Equipo::recogerEquipo($idEquipo); // Se recoge el objeto del equipo

        if (!empty($equipo)) {

            $datosEquipo = $equipo->pintarEquipo(); // HTML con el logo y nombre del equipo
            $equipoCompeticiones = Competicion::recogerEquipoCompeticiones($idEquipo); // Se recogen las competiciones en las que está el equipo

            if (!empty($equipoCompeticiones)) {
                
                // Se generan las opciones de los selects para seleccionar año y competición para ver estadísticas que se recogen desde javascript
                $opcionesCompeticiones = $equipo->generarOpcionesCompeticiones($equipoCompeticiones);
                $opcionesAnios = $equipo->generarOpcionesAnios($equipoCompeticiones);
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/equipo_estadisticas.php';
    include '../view/templates/footer.php';