<?php
    require_once "../model/Usuario.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

    $titulo = "FrancisGol - Cuenta favoritos";
    $lista_css = ["registro_inicio.css", "competiciones.css"];

    $paises2 = crearOpcionesPaises(); // Se generan las opciones para el select que se utiliza para seleccionar las competiciones
    $paises1 = "<option value='' selected>Competiciones generales</option>".$paises2; // Se añade esta opción para que pueda dar favorito a competiciones que no son de ningún pais

    $usuario = unserialize($_SESSION['usuario']); // Se recoge el objeto del usuario

    $fotoUsuario = $usuario->__get("foto"); // Se recoge la foto para que se muestre en la página

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/cuenta_favoritos.php';
    include '../view/templates/footer.php';