<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Equipo estadísticas";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["equipo"]) && !empty($_GET["equipo"])) {

        $idEquipo = $_GET["equipo"];
        $equipo = Equipo::recogerEquipo($idEquipo);

        if (!empty($equipo)) {

            $datosEquipo = $equipo->pintarEquipo();
            
            $equipoCompeticiones = Competicion::recogerEquipoCompeticiones($idEquipo); 

            $opcionesCompeticiones = $equipo->generarOpcionesCompeticiones($equipoCompeticiones);
            $opcionesAnios = $equipo->generarOpcionesAnios($equipoCompeticiones);

        } else {

            $opcionesCompeticiones = "";
            $opcionesAnios = "";
            $datosEquipo = "<p class='parrafo_informacion_blanco'>Equipo no encontrado</p>";
        }

    } else {

        $opcionesCompeticiones = "";
        $opcionesAnios = "";
        $datosEquipo = "<p class='parrafo_informacion_blanco'>Equipo no encontrado</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/equipo_estadisticas.php';
    include '../view/templates/footer.php';