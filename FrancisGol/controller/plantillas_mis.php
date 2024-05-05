<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Mis plantillas";
    $lista_css = ["alineaciones.css"];

    if (isset($_SESSION['usuario'])) {
        
        $usuario = unserialize($_SESSION['usuario']);
        $idUsuario = $usuario->__get("id");
    
        $plantillas = "";
        $plantillasUsuario = Plantilla::recogerPlantillasUsuario($idUsuario, true);

        if (!empty($plantillasUsuario)) {
        
            foreach ($plantillasUsuario as $plantilla) {
    
                $plantillas .= $plantilla->pintarPlantilla("editar");
            }
    
        } else {
    
            $plantillas = "<p>No se encontraron plantillas creadas</p>";
        }

    } else {
        $plantillas = "<p>Debe iniciar sesión para ver sus plantillas</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_mis.php';
    include '../view/templates/footer.php';