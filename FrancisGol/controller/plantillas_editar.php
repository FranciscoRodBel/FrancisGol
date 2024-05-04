<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Editar plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];


    if (isset($_GET['plantilla']) && !empty($_GET['plantilla'])) {

            $plantilla = Plantilla::recogerPlantilla($_GET['plantilla']);

            $equipo = Equipo::recogerEquipo($plantilla->__get("idEquipo"));
            $datosEquipo = $equipo->pintarEquipo();
            
            $optionsSelectFormaciones = Plantilla::generarSelectFormaciones();

            $plantilla = 
            $plantilla = "";
    } else {
        
        $datosEquipo = "";
        $plantilla = "<p>No se encontró la plantilla</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_editar.php';
    include '../view/templates/footer.php';