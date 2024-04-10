<?php
    require_once "../model/consulta_equipo.php";
    
    if (isset($_POST['query'])) {
        
        print_r($_POST['query']);
        $resultado = seleccionarEquipo($_POST['query'], date("Y")-1);
        $equipos = "";
        

        foreach ($resultado->response as $equipo) {

            $equipos .= "<div>";
                // $competiciones .= "<p>ID: ".$equipo->team->id."<br>";
                $equipos .= "<img src=".$equipo->team->logo." alt='logo competición'>";
                $equipos .= "<p>".$equipo->team->name."</p>";
                $equipos .= '<i class="fa-solid fa-star icono_estrella"></i>';
            $equipos .= "</div><hr>";
        }

        echo $equipos;
    }