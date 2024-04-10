<?php
  require_once "../model/consulta_pais.php";

  $titulo = "FrancisGol - Registro";
  $lista_css = ["registro_inicio.css"];
  
  $paises = seleccionarPais();
  
  include '../view/templates/head.php';
  include '../view/templates/header.php';
  include '../view/registro.php';
  include '../view/templates/footer.php';
