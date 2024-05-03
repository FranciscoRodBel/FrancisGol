<?php
   session_start();
   require_once "../model/funciones.inc.php";
   require_once "../model/plantillas_guardar.php";
   require_once "../model/plantillas_crear.php";
   require_once "../model/Usuario.php";

   Usuario::comprobarSesionIniciada(false);

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $datos = json_decode(file_get_contents("php://input"), true);

      if (isset($datos['posicionesJugadores']) && isset($datos['titulo']) && isset($datos['formacion']) && isset($datos['datosPlantilla'])) {
         
         $posicionesJugadores = json_decode($datos['posicionesJugadores'], true);
         $titulo = $datos['titulo'];
         $formacion = $datos['formacion'];
         $datosPlantilla = $datos['datosPlantilla'];

         if (comprobarVacio([$posicionesJugadores, $titulo, $formacion, $datosPlantilla])) {
            

            if (comprobarDatosJugadores($formacion, $posicionesJugadores, $datosPlantilla)) {
               
               guardarDatosJugadores($posicionesJugadores, $titulo, $formacion, $datosPlantilla);

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
