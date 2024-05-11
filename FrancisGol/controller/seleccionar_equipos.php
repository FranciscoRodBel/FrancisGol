<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_POST['query'])) {
        $idCompeticion = $_POST['query'];
        $resultado = realizarConsulta("competicion_equipos_$idCompeticion"."_"."2023", "teams?league=$idCompeticion&season=2023", 86400); 

        $equipos = "";

        foreach ($resultado->response as $equipo) {

            $equipos .= "<div class='competicion_equipo'><a>";
                $equipos .= "<div class='logo_competicion'><img src=".$equipo->team->logo." alt='logo competición'></div>";
                $equipos .= "<span>".$equipo->team->name."</span></a>";
                $equipos .= '<i class="fa-solid fa-star icono_estrella" id="equipo_'.$equipo->team->id.'"></i>'; 
            $equipos .= "</div>";
        }
        echo $equipos;
    }