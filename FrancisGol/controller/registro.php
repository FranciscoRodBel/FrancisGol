<?php
    require_once "../model/Usuario.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    Usuario::comprobarSesionIniciada(true); // Si la sesión está iniciada lo redirige a la página de partidos

    $titulo = "FrancisGol - Registro";
    $lista_css = ["registro_inicio.css", "competiciones.css"];
    
    $paises2 = crearOpcionesPaises(); // Se generan las opciones para el select que se utiliza para seleccionar las competiciones
    $paises1 = "<option value='' selected>Competiciones generales</option>".$paises2; // Añado esa opción para que pueda seleccionar competiciones que no pertenecen a ningún país

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav_inicio_registro.php';
    include '../view/registro.php';
    include '../view/templates/footer.php';
