<?php
    require_once "../model/Usuario.php";
    require_once "../model/Competicion.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_POST['query'])) {

        $competiciones_pais = "";
        
        $resultado = realizarConsulta("competiciones", "leagues", 7776000); // Se recogen todas las competiciones existentes cada 3 meses

        if (!empty($resultado)) {

            $codigoPais = $_POST['query'];
        
            $competicionesFavoritas = Competicion::recogerCompeticionFavorita();
    
            foreach ($resultado->response as $liga) { // Se recorren todas las competiciones y se genera el html para mostrarlo
    
                $claseFavorito = isset($_SESSION["usuario"]) && in_array($liga->league->id, $competicionesFavoritas) ? "favorito" : ""; // Si está en favoritos añade la estrella amarilla y si no lo está la gris
                $competiciones = "<div class='competicion_equipo'><a>";
                    $competiciones .= "<div class='logo_competicion'><img src=".$liga->league->logo." alt='logo competición' loading='lazy'></div>";
                    $competiciones .= "<span>".$liga->league->name."</span></a>";
                    $competiciones .= '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="competicion_'.$liga->league->id.'"></i>';   
                $competiciones .= "</div>";
    
                if ($liga->country->code == $codigoPais) { // Añade para que se muestren todas las competiciones del país seleccionado
                    
                    $competiciones_pais .= $competiciones;
                }
            }
        }

        echo $competiciones_pais;
    }