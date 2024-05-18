<?php
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Equipo plantilla";
    $lista_css = ["competiciones.css"];

    $datosEquipo = "<p class='parrafo_informacion_blanco'>Equipo no encontrado.</p>";  // Si algún dato está vacío se muestra este mensaje
    $plantilla = "";

    if (isset($_GET["equipo"]) && !empty($_GET["equipo"])) { // Si se ha enviado el id del equipo
        
        $idEquipo = $_GET["equipo"];
        $equipo = Equipo::recogerEquipo($idEquipo); // Recoge el objeto del equipo

        if (!empty($equipo)) {

            $datosEquipo = $equipo->pintarEquipo(); // HTML con el logo y nombre del equipo 
            $equipoPlantilla = realizarConsulta("equipo_plantilla_$idEquipo", "/players/squads?team=$idEquipo", 604800); // Recojo la plantilla actual del equipo

            if (!empty($equipoPlantilla)) {

                $plantilla = $equipo->generarPlantilla($equipoPlantilla); // Genera el HTML de los jugadores
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/equipo_plantilla.php';
    include '../view/templates/footer.php';