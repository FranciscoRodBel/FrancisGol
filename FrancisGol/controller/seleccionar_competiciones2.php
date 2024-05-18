<?php
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";
    
    if (isset($_POST['query']) && !empty($_POST['query'])) {

        $resultado = realizarConsulta("competiciones", "leagues", 86400); 
        $competiciones_pais = "";

        if (!empty($resultado)) {

            $codigoPais = $_POST['query'];

            foreach ($resultado->response as $liga) {

                $competicion = "<option value='".$liga->league->id."'>".$liga->league->name."</option>";

                if ($liga->country->code == $codigoPais) {
                    $competiciones_pais .= $competicion;
                }
            }
        }

        echo $competiciones_pais;

    } else if (isset($_GET["texto"]) && !empty($_GET["texto"])) {

        $resultado = realizarConsulta("competiciones", "leagues", 86400); 
        $competiciones_pais = "";

        if (!empty($resultado)) {

            $texto = $_GET['texto'];

            foreach ($resultado->response as $liga) {

                $pattern = "/$texto/i";

                $paisCompeticion = $liga->country->code == null ? $liga->country->name : $liga->country->code;

                if (preg_match($pattern, $liga->league->name." - ".$paisCompeticion)) {

                    $competicion = "<option data-idCompeticion='".$liga->league->id."'>".$liga->league->name." - $paisCompeticion </option>"; 
                    $competiciones_pais .= $competicion; 
                }
            }
        }

        echo $competiciones_pais;
    }