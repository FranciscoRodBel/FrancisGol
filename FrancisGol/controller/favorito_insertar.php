<?php
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/Competicion.php";

    Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

    if (isset($_GET["accion"]) && isset($_GET["id"])) { // Si se envía la acción(comeptición o equipo) y su id

        $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario de la sesión
        $idUsuario = $usuario->__get("id");

        if ($_GET["accion"] == "competicion") {
            
            $competicion = Competicion::recogerCompeticion($_GET["id"]); // Recojo los datos de la competición, al recoger los datos también los guarda en la BBDD si no están ya guardados
            
            $idCompeticion = $competicion->__get("id");
            Competicion::insertarCompeticionFavorita($idCompeticion, $idUsuario); // Guardo la competición favorita del usuario

        } else if ($_GET["accion"] == "equipo") {

            $equipo = Equipo::recogerEquipo($_GET["id"]); // Recojo los datos del equipo, al recoger los datos también los guarda en la BBDD si no están ya guardados
            $idEquipo = $equipo->__get("id");

            Equipo::insertarEquipoFavorito($idEquipo, $idUsuario); // Guardo el equipo favorito del usuario
        }
 
    }