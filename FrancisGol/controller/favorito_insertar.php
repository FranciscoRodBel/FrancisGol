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
            
            $competicion = Competicion::recogerCompeticion($_GET["id"]);
            $idCompeticion = $competicion->__get("id");
            
            Favoritos::insertarCompeticion($idCompeticion, $idUsuario);

        } else if ($_GET["accion"] == "equipo") {

            $equipo = Equipo::recogerEquipo($_GET["id"]);
            $idEquipo = $equipo->__get("id");

            Favoritos::insertarEquipo($idEquipo, $idUsuario);
        }
 
    }