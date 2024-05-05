<?php
   session_start();
   require_once "../model/Usuario.php";
   require_once "../model/Equipo.php";
   require_once "../model/Jugador.php";
   require_once "../model/Plantilla.php";
   require_once "../model/funciones.inc.php";

   Usuario::comprobarSesionIniciada(false);

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $datos = json_decode(file_get_contents("php://input"), true);

      if (isset($datos['posicionesJugadores']) && isset($datos['titulo']) && isset($datos['formacion']) && isset($datos['datosPlantilla']) && isset($datos['accion'])) {
         
         $posicionesJugadores = json_decode($datos['posicionesJugadores'], true);
         $titulo = $datos['titulo'];
         $formacion = $datos['formacion'];
         $datosPlantilla = $datos['datosPlantilla'];
         $accion = $datos['accion'];

         if (comprobarVacio([$posicionesJugadores, $titulo, $formacion, $datosPlantilla])) {
            

            if (Plantilla::comprobarDatosJugadores($formacion, $posicionesJugadores, $datosPlantilla)) {
               
               if ($accion == "guardar") {

                  $idPlantilla = Plantilla::guardarDatosJugadores($posicionesJugadores, $titulo, $formacion, $datosPlantilla);
               
                  header("Location: ../controller/plantillas_editar.php?plantilla=$idPlantilla");
                  die();

               } else if ($accion == "editar") {

                  if (isset($datos['idPlantilla'])) {

                     $idPlantilla = $datos['idPlantilla'];
                     $plantilla = Plantilla::recogerPlantilla($idPlantilla);

                     $usuario = unserialize($_SESSION['usuario']);
                     $idUsuario = $usuario->__get("id");

                     if ($plantilla->__get("idUsuario") == $idUsuario) {
            
                        echo $plantilla->actualizarDatosJugadores($posicionesJugadores, $titulo, $formacion);

                     } else {
             
                         echo "No puede editar esta plantilla";
                     }

                  } else {

                     echo "Los datos enviados no son correctos";
                  }

               }

            } else {

               echo "Los datos de los jugadores no son correctos";
            }

         } else {

            echo "Debe rellenar todos los datos del formulario";
         }
      
      } else {

         echo "Los datos enviados no son correctos";
      }

   } else {

      echo "No se pudieron guardar los datos inténtelo más tarde";
   }
