<?php

    $titulo = "FrancisGol - Competiciones";
    $lista_css = ["competiciones.css"];

    if (isset($_GET["texto"]) && !empty($_GET["texto"])) {



    } 

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/competiciones.php';
    include '../view/templates/footer.php';