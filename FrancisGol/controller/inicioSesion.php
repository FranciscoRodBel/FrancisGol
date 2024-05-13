<?php
    include '../model/Usuario.php';

    Usuario::comprobarSesionIniciada(true);

    $titulo = "FrancisGol - Inicio de sesión";
    $lista_css = ["registro_inicio.css"];
    
    if (isset($_POST['iniciarSesion'])) {

        $email = $_POST['email'];
        $contrasenia = $_POST['contrasenia'];

        $usuario = new Usuario($email); // Creo el objeto del usuario
        $resultadoFormulario = $usuario->comprobarInicioSesion($contrasenia, "inicio"); // Comprobará si la sesión es correcta, si es así iniciará sesión y si no, devolverá un mensaje indicando el error

    } else {
        $resultadoFormulario = "";
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/inicioSesion.php';
    include '../view/templates/footer.php';
