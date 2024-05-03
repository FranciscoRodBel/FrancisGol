<?php
    session_start();
    require_once "../model/realizar_consultas.php";

    if (isset($_POST['query'])) {

        $resultado = realizarConsulta("competiciones", "leagues", 86400); 
        $competiciones_pais = "";
        $codigoPais = $_POST['query'];

        foreach ($resultado->response as $liga) {

            $competiciones = "<div>";
                // $competiciones .= "<p>ID: ".$liga->league->id."<br>";
                $competiciones .= "<img src=".$liga->league->logo." alt='logo competición'>";
                $competiciones .= "<p>".$liga->league->name."</p>";
                $competiciones .= '<i class="fa-solid fa-star icono_estrella"></i>';
                // $competiciones .= "Tipo: ".$liga->league->type."<br>";
            $competiciones .= "</div>";

            if ($liga->country->code == $codigoPais) {
                $competiciones_pais .= $competiciones;
            }

        }

        echo $competiciones_pais;
    }