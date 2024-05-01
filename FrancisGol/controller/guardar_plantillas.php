<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

   $datos = json_decode(file_get_contents("php://input"), true);

   if (isset($datos['posicionesJugadores']) && isset($datos['titulo']) && isset($datos['formacion']) && isset($datos['datosPlantilla'])) {
      
      $posicionesJugadores = $datos['posicionesJugadores'];
      $titulo = $datos['titulo'];
      $formacion = $datos['formacion'];
      $datosPlantilla = $datos['datosPlantilla'];

      echo $datosPlantilla;
   
   } else {

      echo "Los datos enviados no son correctos";
   }

} else {

   echo "No se pudieron guardar los datos inténtelo más tarde";
}