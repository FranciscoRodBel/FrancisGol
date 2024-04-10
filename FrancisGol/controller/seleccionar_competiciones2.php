<?php
    require_once "../model/consulta_competiciones.php";
    
    if (isset($_POST['query'])) {

        $resultado = seleccionarCompeticion();
        $competiciones_pais = "";
        $codigoPais = $_POST['query'];

        foreach ($resultado->response as $liga) {

            $competicion = "<option value='".$liga->league->id."'>".$liga->league->name."</option>";

            if ($liga->country->code == $codigoPais) {
                $competiciones_pais .= $competicion;
            }
        }

        echo $competiciones_pais;
    }