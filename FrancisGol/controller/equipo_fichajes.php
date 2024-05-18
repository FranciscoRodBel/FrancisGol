<?php
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Equipo fichajes";
    $lista_css = ["competiciones.css"];

    $datosEquipo = "<p class='parrafo_informacion_blanco'>Equipo no encontrado.</p>";  // Si algún dato está vacío se muestra este mensaje
    $fichajes = "";

    if (isset($_GET["equipo"]) && !empty($_GET["equipo"])) { // Si se ha enviado el id del equipo
        
        $idEquipo = $_GET["equipo"];
        $equipo = Equipo::recogerEquipo($idEquipo); // Recoge el objeto del equipo

        if (!empty($equipo)) {

            $datosEquipo = $equipo->pintarEquipo(); // HTML con el logo y nombre del equipo 
            $fichajesEquipo = realizarConsulta("fichajes_$idEquipo", "transfers?team=$idEquipo", 86400); // Recoge los fichajes del equipo del año actual

            if (!empty($fichajesEquipo)) {

                $fichajes = Equipo::pintarFichajesEquipo($fichajesEquipo); // Genera el HTML de todos los fichajes
            }
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/equipo_fichajes.php';
    include '../view/templates/footer.php';