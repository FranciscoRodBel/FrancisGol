<?php
  session_start();
  require_once "../model/consulta_pais.php";
  require_once "../model/Usuario.php";

  $titulo = "FrancisGol - Registro";
  $lista_css = ["registro_inicio.css"];
  
  $paises = seleccionarPais();
  $paises2 = crearOpcionesPaises($paises);
  $paises1 = "<option value='' selected>Competiciones generales</option>".$paises2;

  if (isset($_POST['registrarse'])) {

      $usuario = new Usuario($_POST['email']); // Creo el objeto usuario con el email

      // Compruebo que los datos del registro son correctos, dependiendo de si es correcto o no devolverá un mensaje apropiado
      $resultadoFormulario = $usuario->comprobarRegistro($_POST['email'],$_POST['nombre'] , $_POST['contrasenia'], $_POST['repetir_contrasenia'], $_POST['foto']); // Comprobará si los datos son correctos y creará la cuenta

  } else {
      $resultadoFormulario = "";
  }

  include '../view/templates/head.php';
  include '../view/templates/header.php';
  include '../view/registro.php';
  include '../view/templates/footer.php';
