<?php
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Plantillas usuarios";
    $lista_css = ["alineaciones.css"];

    if (isset($_SESSION['usuario'])) { // si el usuario a inciado sesión
        
        $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario de la sesión
        $idUsuario = $usuario->__get("id");

    } else {

        $idUsuario = -1; // Si no ha iniciado doy un id que no exista
    }
    // La idea es que busque todas las plantillas que sean igual al idUsuario

    $plantillas = "";
    $plantillasUsuario = Plantilla::recogerPlantillasUsuario($idUsuario, false); // Recoge todas las plantillas que NO le pertenecen al usuario

    if (!empty($plantillasUsuario)) {
        
        foreach ($plantillasUsuario as $plantilla) { // Recorre todas las plantillas

            $plantillas .= $plantilla->pintarPlantilla("ver"); // Genera el HTML para poder ver las plantillas
        }

    } else {

        $plantillas = "<p class='parrafo_informacion'>No se encontraron plantillas.</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_usuarios.php';
    include '../view/templates/footer.php';