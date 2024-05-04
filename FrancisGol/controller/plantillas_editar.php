<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/plantillas_editar.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Editar plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];


    if (isset($_POST['enviarEquipo']) && isset($_POST['equipos_competicion'])) {

        if (!empty($_POST['equipos_competicion'])) {
            
            // $idEquipo = ;

            // $equipo = Equipo::recogerEquipo($idEquipo);
            // $datosEquipo = $equipo->pintarEquipo();
            $datosEquipo = "";
            
            $optionsSelectFormaciones = generarSelectFormaciones();

            $equipoPlantilla = realizarConsulta("equipo_plantilla_$idEquipo", "/players/squads?team=$idEquipo", 86400); 
            $plantilla = generarPlantilla($equipoPlantilla);
        
        } else {
            $datosEquipo = "";
            $plantilla = "<p>No se encontró el equipo</p>";
        }

    } else {
        $datosEquipo = "";
        $plantilla = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_editar.php';
    include '../view/templates/footer.php';