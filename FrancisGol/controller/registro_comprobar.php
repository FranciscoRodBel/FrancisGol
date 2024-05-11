<?php

    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/funciones.inc.php";

    Usuario::comprobarSesionIniciada(true);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $resultadoFormulario = "";

            $email = comprobarDatos($_POST['email']);
            $nombre = comprobarDatos($_POST['nombre']);
            $contrasenia = comprobarDatos($_POST['contrasenia']);
            $repetir_contrasenia = comprobarDatos($_POST['repetir_contrasenia']);

            if (comprobarVacio([$email, $nombre, $contrasenia, $repetir_contrasenia])) {

                $favoritos = json_decode($_POST['favoritos'], true);
                $competicionesFavoritas = $favoritos["competicion"];
                $equipoFavoritas = $favoritos["equipo"];
    
                $resultadoFormulario = empty($competicionesFavoritas) || empty($equipoFavoritas) ? "Tiene que seleccionar un equipo y una competición." : "";

                if (empty($resultadoFormulario)) {
                    foreach ($competicionesFavoritas as $idCompeticion) {
    
                        if (empty(Competicion::recogerCompeticion($idCompeticion))) {
                            $resultadoFormulario = "Las competiciones en favoritos no son correctos.";
                        }
                    }
                }
    
                if (empty($resultadoFormulario)) {
                    foreach ($equipoFavoritas as $idEquipo) {
    
                        if (empty(Equipo::recogerEquipo($idEquipo))) {
                            $resultadoFormulario = "Los equipos en favoritos no son correctos.";
                        }
                    }
                }
    
                if (empty($resultadoFormulario)) {
    
                    $usuario = new Usuario($email);
                    $resultadoFormulario = $usuario->comprobarRegistro($email, $nombre, $contrasenia, $repetir_contrasenia, $competicionesFavoritas, $equipoFavoritas);
                }
    
                echo $resultadoFormulario;

            } else {

                echo "Debe rellenar todos los datos";
            }

    } else {

        echo "No se puedo realizar el registro.";
    }
