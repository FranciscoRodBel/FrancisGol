<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    Usuario::comprobarSesionIniciada(false);

    $titulo = "FrancisGol - Editar plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];

    if (isset($_GET['plantilla']) && !empty($_GET['plantilla'])) {

            $plantilla = Plantilla::recogerPlantilla($_GET['plantilla']);

            $usuario = unserialize($_SESSION['usuario']);
            $idUsuario = $usuario->__get("id");
    
            if ($plantilla->__get("idUsuario") == $idUsuario) {
                
                $titulo = $plantilla->__get("titulo");
                $formacion = $plantilla->__get("formacion");
                $idPlantilla = $plantilla->__get("id");
    
                $equipo = Equipo::recogerEquipo($plantilla->__get("idEquipo"));
                $datosEquipo = $equipo->pintarEquipo();
                $idEquipo = $equipo->__get("id");
    
                $equipoPlantilla = realizarConsulta("equipo_plantilla_$idEquipo", "/players/squads?team=$idEquipo", 86400); 
                
                $optionsSelectFormaciones = Plantilla::generarSelectFormaciones($formacion);
    
                $datosPlantilla = $plantilla->recogerDatosPlantilla();
                $resultadoPlantilla = $plantilla->pintarPlantillaEditar($datosPlantilla);
    
            } else {
    
                header("Location: ../controller/plantillas_mis.php");
                die();
            }

    } else {
        
        $titulo = "";
        $datosEquipo = "";
        $resultadoPlantilla = "<p>No se encontró la plantilla</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_editar.php';
    include '../view/templates/footer.php';