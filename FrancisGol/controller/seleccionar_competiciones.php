<?php
    session_start();
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";

    if (isset($_POST['query'])) {

        $resultado = realizarConsulta("competiciones", "leagues", 86400); 
        $competiciones_pais = "";
        $codigoPais = $_POST['query'];

        foreach ($resultado->response as $liga) {

            $competiciones = "<div>";
                $competiciones .= "<img src=".$liga->league->logo." alt='logo competición'>";
                $competiciones .= "<p>".$liga->league->name."</p>";
                $competiciones .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella" id="competicion_'.$liga->league->id.'"></i>' : '';   
            $competiciones .= "</div>";

            if ($liga->country->code == $codigoPais) {
                $competiciones_pais .= $competiciones;
            }

        }

        echo $competiciones_pais;
    }