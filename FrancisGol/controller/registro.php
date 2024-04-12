<?php
  require_once "../model/consulta_pais.php";

  $titulo = "FrancisGol - Registro";
  $lista_css = ["registro_inicio.css"];
  
  $paises = seleccionarPais();
  $paises2 = crearOpcionesPaises($paises);
  $paises1 = "<option value='' selected>Competiciones generales</option>".$paises2;
  
  include '../view/templates/head.php';
  include '../view/templates/header.php';
  include '../view/registro.php';
  include '../view/templates/footer.php';
