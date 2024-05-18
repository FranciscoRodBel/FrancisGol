<?php
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Mis plantillas";
    $lista_css = ["alineaciones.css"];

    if (isset($_SESSION['usuario'])) {
        
        $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario de la sesión
        $idUsuario = $usuario->__get("id");
    
        $plantillas = "";
        $plantillasUsuario = Plantilla::recogerPlantillasUsuario($idUsuario, true); // Se recogen todas plantillas que pertenecen al usuario, true si le pertenecen

        if (!empty($plantillasUsuario)) {
        
            foreach ($plantillasUsuario as $plantilla) { // Se recorren todas las plantillas recogidas
    
                $plantillas .= $plantilla->pintarPlantilla("editar"); // Se va generando el HTML para poder editar las plantillas
            }
    
        } else {
    
            $plantillas = "<p class='parrafo_informacion'>No se encontraron plantillas creadas.</p>";
        }

    } else {
        
        $plantillas = "<p class='parrafo_informacion'>Debe iniciar sesión para ver sus plantillas.</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_mis.php';
    include '../view/templates/footer.php';