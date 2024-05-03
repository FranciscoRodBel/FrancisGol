<?php
    session_start();
    if (isset($_GET['formacion'])) {
        
        $formacion = $_GET['formacion'];

        $formacion = explode("-",$formacion);

        $clasesGeneradas = ["jugador_1_1"];
    
        foreach ($formacion as $clave => $numeroJugadoresPosicion) {
            
            for ($i=1; $i <= $numeroJugadoresPosicion; $i++) { 
                
                array_push($clasesGeneradas, "jugador_". $clave+2 ."_".$i);
            }
        }
    
        echo json_encode($clasesGeneradas);
    }

