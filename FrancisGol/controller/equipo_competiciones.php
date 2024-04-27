<?php
    require_once "../model/equipo_competiciones.php";
    require_once "../model/realizar_consultas.php";
    require_once "../model/Equipo.php";

    $titulo = "FrancisGol - competiciones equipo";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["equipo"]) && !empty($_GET["equipo"])) {

        $idEquipo = $_GET["equipo"];
        $datosEquipo = Equipo::recogerEquipo($idEquipo);

    } else {

        header("Location: ../controller/partidos.php");
        exit;
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/equipo_competiciones.php';
    include '../view/templates/footer.php';