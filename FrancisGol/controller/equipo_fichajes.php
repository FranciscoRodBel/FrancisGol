<?php
    require_once "../model/fichajes.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - Equipo fichajes";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["equipo"]) && !empty($_GET["equipo"])) {

        $idEquipo = $_GET["equipo"];
        $datosEquipo = Equipo::recogerEquipo($idEquipo);
         
        $fichajesEquipo = realizarConsulta("fichajes_$idEquipo", "transfers?team=$idEquipo", 86400); 
        $fichajes = pintarFichajesEquipo($fichajesEquipo);

    } else {

        header("Location: ../controller/partidos.php");
        exit;
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/equipo_fichajes.php';
    include '../view/templates/footer.php';