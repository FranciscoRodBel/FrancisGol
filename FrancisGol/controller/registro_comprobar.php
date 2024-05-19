<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/Equipo.php";
    require_once "../model/funciones.inc.php";

    Usuario::comprobarSesionIniciada(true); // Si la sesión está iniciada lo redirige a la página de partidos

    if ($_SERVER["REQUEST_METHOD"] == "POST") { // Si llega un envío por POST...

        $resultadoFormulario = "";

        if (isset($_POST['email']) && isset($_POST['nombre']) && isset($_POST['contrasenia']) && $_POST['repetir_contrasenia'] && isset($_POST['favoritos']) && isset($_FILES['inputFoto'])) {
            
            // Compruebo los datos para evitar ataques
            $email = comprobarDatos($_POST['email']);
            $nombre = comprobarDatos($_POST['nombre']);
            $contrasenia = comprobarDatos($_POST['contrasenia']);
            $repetir_contrasenia = comprobarDatos($_POST['repetir_contrasenia']);

            if (comprobarVacio([$email, $nombre, $contrasenia, $repetir_contrasenia])) { // si no están vacíos

                $favoritos = json_decode($_POST['favoritos'], true); // Recojo los equipos y las competiciones que ha marcado como favoritos
                $competicionesFavoritas = $favoritos["competicion"];
                $equipoFavoritas = $favoritos["equipo"];
    
                $resultadoFormulario = empty($competicionesFavoritas) || empty($equipoFavoritas) ? "Tiene que seleccionar un equipo y una competición." : "";

                if (empty($resultadoFormulario)) { // Si no está vacío significa que han enviado al menos un equipo y una competición
                    
                    foreach ($competicionesFavoritas as $idCompeticion) { // Recorro las competiciones favoritas
    
                        if (empty(Competicion::recogerCompeticion($idCompeticion))) { // Voy comprobando si existe la competición(si existen las guarda en la BBDD)

                            $resultadoFormulario = "Las competiciones en favoritos no son correctas.";
                        }
                    }

                    foreach ($equipoFavoritas as $idEquipo) { // Recorro los equipos favoritos
    
                        if (empty(Equipo::recogerEquipo($idEquipo))) {  // Voy comprobando si existe el equipo(si existen las guarda en la BBDD)
                            
                            $resultadoFormulario = "Los equipos en favoritos no son correctos.";
                        }
                    }

                    $usuario = new Usuario($email); // Creo el objeto usuario y envío los datos para que se comprueben y se guarden
                    $resultadoFormulario = $usuario->comprobarRegistro($email, $nombre, $contrasenia, $repetir_contrasenia, $competicionesFavoritas, $equipoFavoritas);
                }
    
                echo $resultadoFormulario;

            } else {

                echo "Debe rellenar todos los datos.";
            }

        } else {

            echo "Debe rellenar todos los datos.";
        }

    } else {

        echo "No se puedo realizar el registro.";
    }
