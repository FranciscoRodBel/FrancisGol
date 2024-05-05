<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/Competicion.php";
    require_once "../model/Favoritos.php";

    Usuario::comprobarSesionIniciada(false);

    if (isset($_GET["accion"]) && isset($_GET["id"])) {

        $usuario = unserialize($_SESSION['usuario']);
        $idUsuario = $usuario->__get("id");

        if ($_GET["accion"] == "competicion") {
            
            echo Favoritos::eliminarCompeticion($_GET["id"], $idUsuario);

        } else if ($_GET["accion"] == "equipo") {

            echo Favoritos::eliminarEquipo($_GET["id"], $idUsuario);
        }
 
    }