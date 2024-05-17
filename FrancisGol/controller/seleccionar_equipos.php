<?php
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_POST['query'])) {
        $idCompeticion = $_POST['query'];

        $resultado = realizarConsulta("competicion_equipos_$idCompeticion"."_"."2023", "teams?league=$idCompeticion&season=2023", 604800); 

        if (!empty($resultado)) {
        $equipos = "";

        $equiposFavoritos = Equipo::recogerEquiposFavorito();

            foreach ($resultado->response as $equipo) {

                $claseFavorito = isset($_SESSION["usuario"]) && in_array($equipo->team->id, $equiposFavoritos) ? "favorito" : "";
                $equipos .= "<div class='competicion_equipo'><a>";
                    $equipos .= "<div class='logo_competicion'><img src=".$equipo->team->logo." alt='logo competición'></div>";
                    $equipos .= "<span>".$equipo->team->name."</span></a>";
                    $equipos .= '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="equipo_'.$equipo->team->id.'"></i>'; 
                $equipos .= "</div>";
            }

            echo $equipos;

        } else {

            echo "<p class='parrafo_informacion_blanco'>No se encontraron equipos</p>";
        }
    }