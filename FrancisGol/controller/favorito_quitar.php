<?php
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/Competicion.php";

    Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

    if (isset($_GET["accion"]) && isset($_GET["id"])) { // Si se envía la acción(comeptición o equipo) y su id

        $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario de la sesión
        $idUsuario = $usuario->__get("id");

        if ($_GET["accion"] == "competicion") {
            
            echo Competicion::eliminarCompeticionFavorita($_GET["id"], $idUsuario); // Elimina la competición favorita del usuario pero mantiene la competición almacenada en la BBDD

        } else if ($_GET["accion"] == "equipo") {

            echo Equipo::eliminarEquipoFavorito($_GET["id"], $idUsuario);  // Elimina el equipo favorito del usuario pero mantiene el equipo almacenado en la BBDD
        }
        // Tienen un echo para devolver el resultado del fetch para indicar si fue eliminado o no
    }