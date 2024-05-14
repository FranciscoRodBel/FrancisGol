<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_POST['query'])) {

        $resultado = realizarConsulta("competiciones", "leagues", 86400); 
        $competiciones_pais = "";
        $codigoPais = $_POST['query'];
        
        $competicionesFavoritas = Competicion::recogerCompeticionFavorita();

        foreach ($resultado->response as $liga) {

            $claseFavorito = isset($_SESSION["usuario"]) && in_array($liga->league->id, $competicionesFavoritas) ? "favorito" : "";
            $competiciones = "<div class='competicion_equipo'><a>";
                $competiciones .= "<div class='logo_competicion'><img src=".$liga->league->logo." alt='logo competición'></div>";
                $competiciones .= "<span>".$liga->league->name."</span></a>";
                $competiciones .= '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="competicion_'.$liga->league->id.'"></i>';   
            $competiciones .= "</div>";

            if ($liga->country->code == $codigoPais) {
                $competiciones_pais .= $competiciones;
            }

        }
        echo $competiciones_pais;
    }