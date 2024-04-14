<?php
  require_once "../model/partidos.php";

  $titulo = "FrancisGol - Resumen partido";
  $lista_css = ["partidos_liga.css"];
  
  if (isset($_GET["idPartido"]) && !empty($_GET["idPartido"])) {
      
    $resumen_partido = recogerResumenPartido($_GET["idPartido"]);
    
  } else {
    
    header("Location: ../controller/partidos.php");
    exit;

  }

  include '../view/templates/head.php';
  include '../view/templates/header.php';
  include '../view/templates/nav.php';
  include '../view/resumen_partido.php';
  include '../view/templates/footer.php';