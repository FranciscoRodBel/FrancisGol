<?php
  require_once "../model/resumen_partido.php";

  $titulo = "FrancisGol - Resumen partido";
  $lista_css = ["partidos_liga.css"];
  
  if (isset($_GET["partido"]) && !empty($_GET["partido"])) {
  
    $partido = json_decode(urldecode($_GET["partido"]));;

    $idPartido = $partido->fixture->id;
    $idEquipoLocal = $partido->teams->home->id;
    $idEquipoVisitante = $partido->teams->away->id;

    $eventosPartido = recogerResumenPartido($idPartido);
    $resumenPartido = pintarResumenPartido($eventosPartido, $idEquipoLocal, $idEquipoVisitante);
    
  } else {
    
    header("Location: ../controller/partidos.php");
    exit;

  }

  include '../view/templates/head.php';
  include '../view/templates/header.php';
  include '../view/templates/nav.php';
  include '../view/resumen_partido.php';
  include '../view/templates/footer.php';