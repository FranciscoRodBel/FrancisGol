<?php
  require_once "../controller/seleccionar_pais.php";

  $titulo = "FrancisGol - Registro";
  // $css = "inicio.css";
  
  $paises = seleccionarPais();
  
  include '../view/templates/head.php';
  include '../view/templates/header.php';
  include '../view/registro.php';
  include '../view/templates/footer.php';
