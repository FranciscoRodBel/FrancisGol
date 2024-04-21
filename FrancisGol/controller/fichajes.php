<?php
    require_once "../model/consulta_pais.php";
    require_once "../model/fichajes.php";

    $titulo = "FrancisGol - Registro";
    $lista_css = ["registro_inicio.css"];

    $paises = seleccionarPais();
    $paises = crearOpcionesPaises($paises);

    if (isset($_POST['enviar']) && isset($_POST['equipos_competicion'])) {

        if (!empty($_POST['equipos_competicion'])) {
            
            $idEquipo = $_POST['equipos_competicion'];
            $fichajesEquipo = recogerFichajes($idEquipo);
            $fichajes = pintarFichajesEquipo($fichajesEquipo);

        } else {
            $fichajes = "<p>No se encontró el equipo<p>";
        }

    } else {
        $fichajes = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/fichajes.php';
    include '../view/templates/footer.php';
