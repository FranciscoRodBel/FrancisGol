<?php
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";
    
    if (isset($_POST['query']) && !empty($_POST['query'])) {
        
        $idCompeticion = $_POST['query'];

        $anioActual = date("Y") - 1;
        $resultado = realizarConsulta("competicion_equipos_$idCompeticion"."_".$anioActual, "teams?league=$idCompeticion&season=$anioActual", 604800); 
        $equipos = "";

        if (!empty($resultado)) {

            foreach ($resultado->response as $equipo) {
    
                $equipos .= "<option value='".$equipo->team->id."'>".$equipo->team->name."</option>";
            }
        }

        echo $equipos;
    }