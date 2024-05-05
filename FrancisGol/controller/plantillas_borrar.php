<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Plantilla.php";

    Usuario::comprobarSesionIniciada(false);

    if (isset($_GET["plantilla"])) {
        
        $plantilla = Plantilla::recogerPlantilla($_GET['plantilla']);

        $usuario = unserialize($_SESSION['usuario']);
        $idUsuario = $usuario->__get("id");

        if ($plantilla->__get("idUsuario") == $idUsuario) {
            
            $plantilla->borrarPlantilla();
            header("Location: ../controller/plantillas_mis.php");
            die();

        } else {

            echo "No puede borrar esta plantilla";
        }
        
    } else {

        echo "No se pudieron borrar los datos";
    }