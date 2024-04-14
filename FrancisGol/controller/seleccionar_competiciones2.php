<?php
    require_once "../model/competiciones.php";
    
    if (isset($_POST['query']) && !empty($_POST['query'])) {

        $resultado = recogerCompeticion();
        $competiciones_pais = "";
        $codigoPais = $_POST['query'];

        foreach ($resultado->response as $liga) {

            $competicion = "<option value='".$liga->league->id."'>".$liga->league->name."</option>";

            if ($liga->country->code == $codigoPais) {
                $competiciones_pais .= $competicion;
            }
        }

        echo $competiciones_pais;

    } else if (isset($_GET["texto"]) && !empty($_GET["texto"])) {

        $resultado = recogerCompeticion();
        $competiciones_pais = "";

        foreach ($resultado->response as $liga) {

            $texto = $_GET['texto'];
            $pattern = "/^$texto/i";

            if (preg_match($pattern, $liga->league->name)) {
                $competicion = "<option data-idCompeticion='".$liga->league->id."'>".$liga->league->name."</option>"; 
                $competiciones_pais .= $competicion; 
            }
        }

        echo $competiciones_pais;
    }