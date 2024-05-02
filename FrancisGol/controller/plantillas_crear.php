<?php
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/plantillas_crear.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Crear plantilla";
    $lista_css = ["registro_inicio.css", "alineaciones.css"];

    $paises = realizarConsulta("paises", "countries", 86400); 
    $paises = crearOpcionesPaises($paises);

    if (isset($_POST['enviarEquipo']) && isset($_POST['equipos_competicion'])) {

        if (!empty($_POST['equipos_competicion'])) {
            
            $idEquipo = $_POST['equipos_competicion'];

            $equipo = Equipo::recogerEquipo($idEquipo);
            $datosEquipo = $equipo->pintarEquipo();
            
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
    include '../view/plantillas_crear.php';
    include '../view/templates/footer.php';