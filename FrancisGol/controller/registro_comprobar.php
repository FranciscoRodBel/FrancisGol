<?php

    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/funciones.inc.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $resultadoFormulario = "";

            $email = comprobarDatos($_POST['email']);
            $nombre = comprobarDatos($_POST['nombre']);
            $contrasenia = comprobarDatos($_POST['contrasenia']);
            $repetir_contrasenia = comprobarDatos($_POST['repetir_contrasenia']);

            $favoritos = json_decode($_POST['favoritos'], true);
            $competicionesFavoritas = $favoritos["competicion"];
            $equipoFavoritas = $favoritos["equipo"];
            
            // foreach ($competicionesFavoritas as $idCompeticion) {
            //     echo json_encode($idCompeticion);
            // }
            
            foreach ($equipoFavoritas as $idEquipo) {

                if (empty(Equipo::recogerEquipo($idEquipo))) {
                    $resultadoFormulario = "Los equipos en favoritos no son correctos";
                }
            }

            if (empty($resultadoFormulario)) {

                $usuario = new Usuario($email);
                $resultadoFormulario = $usuario->comprobarRegistro($email, $nombre, $contrasenia, $repetir_contrasenia);
            }

            echo $resultadoFormulario;

        

    } else {

        echo "Acceso denegado";
    }
