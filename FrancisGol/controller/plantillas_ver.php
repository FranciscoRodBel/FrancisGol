<?php
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Ver plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];

    $nombreUsuario = "";
    $tituloPlantilla = "";
    $datosEquipo = "";
    $formacion = "";
    $resultadoPlantilla = "<p>No se encontró la plantilla</p>";

    if (isset($_GET['plantilla']) && !empty($_GET['plantilla'])) {
        
        $plantilla = Plantilla::recogerPlantilla($_GET['plantilla']);
        
        if (!empty($plantilla)) {

            $nombreUsuario = Usuario::recogerNombreUsuario($plantilla->__get("idUsuario"));
            $tituloPlantilla = $plantilla->__get("titulo");
            $formacion = $plantilla->__get("formacion");
            
            $equipo = Equipo::recogerEquipo($plantilla->__get("idEquipo"));

            if (!empty($equipo)) {

                $datosEquipo = $equipo->pintarEquipo();
                $idEquipo = $equipo->__get("id");
                
                $equipoPlantilla = realizarConsulta("equipo_plantilla_$idEquipo", "/players/squads?team=$idEquipo", 604800); 
                
                if (!empty($equipoPlantilla)) {

                    $optionsSelectFormaciones = Plantilla::generarSelectFormaciones($formacion);
                    $datosPlantilla = $plantilla->recogerDatosPlantilla();
                    $resultadoPlantilla = $plantilla->pintarPlantillaEditar($datosPlantilla);
                }
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_ver.php';
    include '../view/templates/footer.php';
