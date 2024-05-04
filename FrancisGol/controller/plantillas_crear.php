<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";
    require_once "../model/Equipo.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";


    $titulo = "FrancisGol - Crear plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];

    $paises = realizarConsulta("paises", "countries", 86400); 
    $paises = crearOpcionesPaises($paises);

    if (isset($_POST['enviarEquipo']) && isset($_POST['equipos_competicion'])) {

        if (!empty($_POST['equipos_competicion'])) {
            
            $idEquipo = $_POST['equipos_competicion'];

            $equipo = Equipo::recogerEquipo($idEquipo);
            $datosEquipo = $equipo->pintarEquipo();
            
            $optionsSelectFormaciones = Plantilla::generarSelectFormaciones();

            $equipoPlantilla = realizarConsulta("equipo_plantilla_$idEquipo", "/players/squads?team=$idEquipo", 86400); 
            $plantilla = Plantilla::generarPlantilla($equipoPlantilla);
        
        } else {
            $datosEquipo = "";
            $plantilla = "<p>No se encontró el equipo</p>";
        }

    } else {
        $datosEquipo = "";
        $plantilla = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/plantillas_crear.php';
    include '../view/templates/footer.php';