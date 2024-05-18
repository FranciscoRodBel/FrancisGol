<?php
    require_once "../model/Usuario.php";
    
    if (isset($_GET['formacion'])) { // Se envía una formación por fetch
        
        $formacion = $_GET['formacion'];

        $formacion = explode("-",$formacion); // Se separa en un array por el guión, ejemplo: 4-3-3 = array(4,3,3)

        $clasesGeneradas = ["jugador_1_1"]; // La primera clase siempre es la misma y para el portero
    
        foreach ($formacion as $clave => $numeroJugadoresPosicion) { // Recorro los números del array que serán el número de jugadores por posición
            
            for ($i=1; $i <= $numeroJugadoresPosicion; $i++) { // Se generan las clases que tendrán los jugadores para colocarse en sus posiciones en la alineación
                
                array_push($clasesGeneradas, "jugador_". $clave+2 ."_".$i);
            }
        }

        // Ejemplo con la 4-3-3
        //  1  -  jugador_1_1
        //  4  -  jugador_2_1,  jugador_2_2,  jugador_2_3,  jugador_2_4
        //  3  -  jugador_3_1,  jugador_3_2,  jugador_3_3
        //  3  -  jugador_4_1,  jugador_4_2,  jugador_4_3
    
        echo json_encode($clasesGeneradas); // Convierto el array con las formación a json y lo devuelvo
    }

