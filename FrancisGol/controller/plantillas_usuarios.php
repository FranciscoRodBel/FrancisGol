<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Plantillas usuarios";
    $lista_css = ["alineaciones.css"];

    if (isset($_SESSION['usuario'])) {
        
        $usuario = unserialize($_SESSION['usuario']);
        $idUsuario = $usuario->__get("id");

    } else {
        $idUsuario = -1;
    }

    $plantillas = "";
    $plantillasUsuario = Plantilla::recogerPlantillasUsuario($idUsuario, false);

    if (!empty($plantillasUsuario)) {
        
        foreach ($plantillasUsuario as $plantilla) {

            $plantillas .= $plantilla->pintarPlantilla("ver");
        }

    } else {

        $plantillas = "<p>No se encontraron plantillas</p>";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_usuarios.php';
    include '../view/templates/footer.php';