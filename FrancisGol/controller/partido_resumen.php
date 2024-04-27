<?php
  require_once "../model/partido_resumen.php";
  require_once "../model/realizar_consultas.php";

  $titulo = "FrancisGol - Resumen partido";
  $lista_css = ["partidos_liga.css"];
  
  if (isset($_GET["partido"]) && !empty($_GET["partido"])) {
  
    $idPartido = $_GET["partido"];

    $partido = realizarConsulta("datos_partido_$idPartido", "fixtures?id=$idPartido", 86400); 
    $partido = $partido->response[0];

    $idEquipoLocal = $partido->teams->home->id;
    $idEquipoVisitante = $partido->teams->away->id;
    
    $eventosPartido = realizarConsulta("partido_resumen_$idPartido", "fixtures/events?fixture=$idPartido", 86400); 
    $resumenPartido = pintarResumenPartido($eventosPartido, $idEquipoLocal, $idEquipoVisitante);
    
  } else {
    
    header("Location: ../controller/partidos.php");
    exit;

  }

  include '../view/templates/head.php';
  include '../view/templates/header.php';
  include '../view/templates/nav.php';
  include '../view/partido_resumen.php';
  include '../view/templates/footer.php';