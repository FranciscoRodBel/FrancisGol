<?php
  require_once "../model/partidos.php";
  require_once "../model/consulta_partidos.php";

  $titulo = "FrancisGol - Partidos";
  $lista_css = ["partidos_liga.css"];


  $fechas_partidos = generarFechasPartidos();
  
  if (isset($_GET["fecha"]) && !empty($_GET["fecha"])) {
      
    $partidos = recogerPartidos($_GET["fecha"]);
    
  } else {
    
    $partidos = recogerPartidos(date("Y-m-d"));
  }

  $partidosSeleccionados = pintarPartidos($partidos);
  

  include '../view/templates/head.php';
  include '../view/templates/header.php';
  include '../view/templates/nav.php';
  include '../view/partidos.php';
  include '../view/templates/footer.php';