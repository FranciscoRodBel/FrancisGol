<?php
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Equipo plantilla";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["equipo"]) && !empty($_GET["equipo"])) {

        $idEquipo = $_GET["equipo"];
        $equipo = Equipo::recogerEquipo($idEquipo);

        if (!empty($equipo)) {

            $datosEquipo = $equipo->pintarEquipo();
            
            $equipoPlantilla = realizarConsulta("equipo_plantilla_$idEquipo", "/players/squads?team=$idEquipo", 604800); 
            $plantilla = $equipo->generarPlantilla($equipoPlantilla);

        } else {

            $plantilla = "";
            $datosEquipo = "<p class='parrafo_informacion_blanco'>Equipo no encontrado</p>";
        }

    } else {

        $plantilla = "";
        $datosEquipo = "<p class='parrafo_informacion_blanco'>Equipo no encontrado</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/equipo_plantilla.php';
    include '../view/templates/footer.php';