<?php
   require_once "../model/funciones.inc.php";
   require_once "../model/plantillas_guardar.php";

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {

      $datos = json_decode(file_get_contents("php://input"), true);

      if (isset($datos['posicionesJugadores']) && isset($datos['titulo']) && isset($datos['formacion']) && isset($datos['datosPlantilla'])) {
         
         $posicionesJugadores = $datos['posicionesJugadores'];
         $titulo = $datos['titulo'];
         $formacion = $datos['formacion'];
         $datosPlantilla = $datos['datosPlantilla'];

         if (comprobarVacio([$posicionesJugadores, $titulo, $formacion, $datosPlantilla])) {
            
            echo $datosPlantilla;

         } else {

            echo "Debe rellenar todos los datos del formulario";
         }
      
      } else {

         echo "Los datos enviados no son correctos";
      }

   } else {

      echo "No se pudieron guardar los datos inténtelo más tarde";
   }