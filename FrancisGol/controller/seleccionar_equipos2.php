<?php
    require_once "../model/realizar_consultas.php";
    
    if (isset($_POST['query'])) {
        
        $idCompeticion = $_POST['query'];
        $resultado = realizarConsulta("competicion_equipos_$idCompeticion"."_"."2023", "teams?league=$idCompeticion&season=2023", 86400); 

        $equipos = "";

        foreach ($resultado->response as $equipo) {

            $equipos .= "<option value='".$equipo->team->id."'>".$equipo->team->name."</option>";
        }

        echo $equipos;
    }