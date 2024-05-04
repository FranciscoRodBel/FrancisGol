<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Editar plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];


    if (isset($_GET['plantilla']) && !empty($_GET['plantilla'])) {

            $idPlantilla = $_GET['plantilla'];
            
            $plantilla = Plantilla::recogerPlantilla($idPlantilla);
            $idEquipo = $plantilla->__get("idEquipo");

            $equipo = Equipo::recogerEquipo($idEquipo);
            $datosEquipo = $equipo->pintarEquipo();
            
            $optionsSelectFormaciones = Plantilla::generarSelectFormaciones();

            $equipoPlantilla = realizarConsulta("equipo_plantilla_$idEquipo", "/players/squads?team=$idEquipo", 86400); 
            $plantilla = Plantilla::generarPlantilla($equipoPlantilla);

    } else {
        $datosEquipo = "";
        $plantilla = "<p>No se encontró la plantilla</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_editar.php';
    include '../view/templates/footer.php';