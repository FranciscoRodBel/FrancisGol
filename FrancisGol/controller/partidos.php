<?php
  require_once "../model/partidos.php";
  require_once "../model/partidosDirecto2.php";

  $titulo = "FrancisGol - Partidos";
  $lista_css = ["partidos_liga.css"];


  $fechas_partidos = generarFechasPartidos();
  
  // if (isset($_GET["fecha"]) && !empty($_GET["fecha"])) {
      
  //   $partidos = recogerPartidos($_GET["fecha"]);

    
  // }

  $resultado = partidos();

  include '../view/templates/head.php';
  include '../view/templates/header.php';
  include '../view/templates/nav.php';
  include '../view/partidos.php';
  include '../view/templates/footer.php';