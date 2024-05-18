<?php
   require_once "../model/Usuario.php";
   require_once "../model/Equipo.php";
   require_once "../model/Jugador.php";
   require_once "../model/Plantilla.php";
   require_once "../model/funciones.inc.php";

   Usuario::comprobarSesionIniciada(false); // Si la sesión no está iniciada lo redirige a la página de partidos

   if ($_SERVER['REQUEST_METHOD'] === 'POST') { // Si llega un envío por POST...

      $datos = json_decode(file_get_contents("php://input"), true); // Recoge todos los datos enviados por POST y genera un array asociativo

      if (isset($datos['posicionesJugadores']) && isset($datos['titulo']) && isset($datos['formacion']) && isset($datos['datosPlantilla']) && isset($datos['accion'])) { // Si han llegado todos los datos esperados...
         
         $posicionesJugadores = json_decode($datos['posicionesJugadores'], true); // Recoge las posiciones de los jugadores
         
         // Compruebo que los datos para evitar ataques
         $titulo = comprobarDatos($datos['titulo']);
         $formacion = comprobarDatos($datos['formacion']);
         $datosPlantilla = $datos['datosPlantilla'];
         $accion = comprobarDatos($datos['accion']);

         if (comprobarVacio([$posicionesJugadores, $titulo, $formacion, $datosPlantilla])) { // Si los datos no están vacíos
            
            if (strlen($titulo) < 200) { // Compruebo que el título tenga como másimo 200 caracteres

               if (Plantilla::comprobarDatosJugadores($formacion, $posicionesJugadores, $datosPlantilla)) { // Si las posiciones enviadas son correctas
                  
                  // Si todos los datos son correctos...

                  if ($accion == "guardar") { // Si quiere guardar los datos...

                     $idPlantilla = Plantilla::guardarDatosJugadores($posicionesJugadores, $titulo, $formacion, $datosPlantilla);
                  
                     header("Location: ../controller/plantillas_editar.php?plantilla=$idPlantilla"); // Envío al usuario a la página para editar la plantilla que acaba de crear
                     die();

                  } else if ($accion == "editar") { // Si quiere editar los datos...

                     if (isset($datos['idPlantilla']) && !empty($datos['idPlantilla'])) { // Si el id de la plantilla está 

                        $idPlantilla = $datos['idPlantilla'];
                        $plantilla = Plantilla::recogerPlantilla($idPlantilla); // Se crea el objeto de la plantilla
                        
                        if (!empty($plantilla)) {
                           
                           $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario de la sesión
                           $idUsuario = $usuario->__get("id");
   
                           if ($plantilla->__get("idUsuario") == $idUsuario) { // Si el id del usuario que tiene la sesión inciada es igual al propietario de la plantilla...
                  
                              echo $plantilla->actualizarDatosJugadores($posicionesJugadores, $titulo, $formacion);
   
                           } else {
                  
                              echo "No puede editar esta plantilla.";
                           }

                        } else {

                           echo "No se encontró la plantilla.";
                        }

                     } else {

                        echo "Los datos enviados no son correctos.";
                     }

                  }

               } else {

                  echo "Los datos de la plantilla no son correctos.";
               }
               
            }  else {
               
               echo "El título no puede ser superior a 200 caracteres.";
            }

         } else {

            echo "Debe rellenar todos los datos del formulario.";
         }
      
      } else {

         echo "Los datos enviados no son correctos.";
      }

   } else {

      echo "No se pudieron guardar los datos inténtelo más tarde.";
   }

   // Se envía el mensaje correspondiente al guardado de la plantilla