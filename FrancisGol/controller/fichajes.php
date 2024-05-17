<?php
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Fichajes";
    $lista_css = ["registro_inicio.css"];

    $paises = crearOpcionesPaises();

    $fichajes = "<p class='parrafo_informacion'>No se encontró el equipo</p>";

    if (isset($_POST['enviar']) && isset($_POST['equipos_competicion'])) {
        
        if (!empty($_POST['equipos_competicion'])) {

            $idEquipo = $_POST['equipos_competicion'];
            $fichajesEquipo = realizarConsulta("fichajes_$idEquipo", "transfers?team=$idEquipo", 86400);

            if (!empty($fichajesEquipo)) {

                $fichajes = Equipo::pintarFichajesEquipo($fichajesEquipo);
            }
        }

    } elseif (isset($_SESSION["usuario"])) {

        $equiposFavoritos = Equipo::recogerEquiposFavorito();

        if (!empty($equiposFavoritos)) {

            $fichajes = Equipo::generarSelectEquipos($equiposFavoritos);
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/fichajes.php';
    include '../view/templates/footer.php';
