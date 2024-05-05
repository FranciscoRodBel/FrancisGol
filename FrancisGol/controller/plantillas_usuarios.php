<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Mis plantillas";
    $lista_css = ["alineaciones.css"];

    $usuario = unserialize($_SESSION['usuario']);
    $idUsuario = $usuario->__get("id");

    $plantillas = "";
    $plantillasUsuario = Plantilla::recogerPlantillasUsuario($idUsuario, false);

    if (!empty($plantillasUsuario)) {
        
        foreach ($plantillasUsuario as $plantilla) {

            $plantillas .= $plantilla->pintarPlantilla();
        }

    } else {

        $plantillas = "No se encontraron plantillas";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_usuarios.php';
    include '../view/templates/footer.php';