<?php
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";

    Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

    if (isset($_GET["plantilla"]) && !empty($_GET["plantilla"])) { // Si se envía el id de la plantilla...
        
        $plantilla = Plantilla::recogerPlantilla($_GET['plantilla']); // Se crea el objeto de la plantilla

        $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario de la sesión
        $idUsuario = $usuario->__get("id");

        if ($plantilla->__get("idUsuario") == $idUsuario) { // Si el id del usuario que tiene la sesión inciada es igual al propietario de la plantilla...
            
            $plantilla->borrarPlantilla(); // Borra la plantilla, también se borran los jugadores automáticamente ya que las claves foráneas de la BBDD están en CASCADE
            header("Location: ../controller/plantillas_mis.php"); // Redirecciona a la página de "mis plantillas"
            die();

        } else {

            echo "No puede borrar esta plantilla";
        }
        
    } else {

        echo "No se pudieron borrar los datos";
    }