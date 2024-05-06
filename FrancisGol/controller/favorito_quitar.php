<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/Competicion.php";

    Usuario::comprobarSesionIniciada(false);

    if (isset($_GET["accion"]) && isset($_GET["id"])) {

        $usuario = unserialize($_SESSION['usuario']);
        $idUsuario = $usuario->__get("id");

        if ($_GET["accion"] == "competicion") {
            
            echo Competicion::eliminarCompeticionFavorita($_GET["id"], $idUsuario);

        } else if ($_GET["accion"] == "equipo") {

            echo Equipo::eliminarEquipoFavorito($_GET["id"], $idUsuario);
        }
 
    }