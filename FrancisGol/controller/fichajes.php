<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Registro";
    $lista_css = ["registro_inicio.css"];

    $paises = realizarConsulta("paises", "countries", 86400); 
    $paises = crearOpcionesPaises($paises);

    if (isset($_POST['enviar']) && isset($_POST['equipos_competicion'])) {

        if (!empty($_POST['equipos_competicion'])) {
            
            $idEquipo = $_POST['equipos_competicion'];
            $fichajesEquipo = realizarConsulta("fichajes_$idEquipo", "transfers?team=$idEquipo", 86400); 

            $fichajes = Equipo::pintarFichajesEquipo($fichajesEquipo);

        } else {
            $fichajes = "<p>No se encontró el equipo</p>";
        }

    } else {

        if (isset($_SESSION["usuario"])) {

            $equiposFavoritos = Equipo::recogerEquiposFavorito();
            $fichajes = Equipo::generarSelectEquipos($equiposFavoritos);

        } else {
            
            $fichajes = "";
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/fichajes.php';
    include '../view/templates/footer.php';
