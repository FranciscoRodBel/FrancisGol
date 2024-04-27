<?php
    require_once "../model/realizar_consultas.php";

    if (isset($_POST['query'])) {
        $idCompeticion = $_POST['query'];
        $resultado = realizarConsulta("competicion_equipos_$idCompeticion"."_"."2023", "teams?league=$idCompeticion&season=2023", 86400); 

        $equipos = "";

        foreach ($resultado->response as $equipo) {

            $equipos .= "<div>";
                // $competiciones .= "<p>ID: ".$equipo->team->id."<br>";
                $equipos .= "<img src=".$equipo->team->logo." alt='logo competición'>";
                $equipos .= "<p>".$equipo->team->name."</p>";
                $equipos .= '<i class="fa-solid fa-star icono_estrella"></i>';
            $equipos .= "</div>";
        }

        echo $equipos;
    }