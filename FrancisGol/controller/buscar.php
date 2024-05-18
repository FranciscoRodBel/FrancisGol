<?php
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/paises.php";
    require_once "../model/Competicion.php";
    
    $titulo = "FrancisGol - Buscar";
    $lista_css = ["competiciones.css"];

    $paises = crearOpcionesPaises(); // Se generan las opciones para el select que se utiliza para seleccionar las competiciones

    $resultadoCompeticiones = Competicion::pintarCompeticionesFavoritas(); // Devuelve el HTML con las competiciones favoritas
    
    $resultadoEquipos = Equipo::pintarEquiposFavoritos(); // Devuelve el HTML con los equipos favoritas

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/buscar.php';
    include '../view/templates/footer.php';