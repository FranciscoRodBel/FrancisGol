<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";

    $titulo = "FrancisGol - Mis plantillas";
    $lista_css = ["alineaciones.css"];

    $usuario = unserialize($_SESSION['usuario']);
    $idUsuario = $usuario->id;

    $plantillas = "";
    $plantillasUsuario = Plantilla::recogerPlantillasUsuario($idUsuario);

    if (!empty($plantillasUsuario)) {
        
        foreach ($plantillasUsuario as $plantilla) {

            $plantillas .= $plantilla->pintarPlantilla();
        }

    } else {

        echo "No se encontraron plantillas creadas";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_mis.php';
    include '../view/templates/footer.php';