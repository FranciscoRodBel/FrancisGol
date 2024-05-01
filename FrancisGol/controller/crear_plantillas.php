<?php
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/crear_plantillas.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Crear plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];

    $paises = realizarConsulta("paises", "countries", 86400); 
    $paises = crearOpcionesPaises($paises);

    if (isset($_POST['enviarEquipo']) && isset($_POST['equipos_competicion'])) {

        if (!empty($_POST['equipos_competicion'])) {
            
            $idEquipo = $_POST['equipos_competicion'];

            $datosEquipo = Equipo::recogerEquipo($idEquipo);
            $optionsSelectFormaciones = generarSelectFormaciones();

            $equipoPlantilla = realizarConsulta("equipo_plantilla_$idEquipo", "/players/squads?team=$idEquipo", 86400); 
            $plantilla = generarPlantilla($equipoPlantilla);
        
        } else {
            $plantilla = "<p>No se encontró el equipo</p>";
        }

    } else {
        $plantilla = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/crear_plantillas.php';
    include '../view/templates/footer.php';