<?php
    require_once "../model/consulta_equipo.php";
    
    if (isset($_POST['query'])) {
        
        $resultado = seleccionarEquipo($_POST['query'], date("Y")-1);

        $equipos = "";

        foreach ($resultado->response as $equipo) {

            $equipos .= "<option value='".$equipo->team->id."'>".$equipo->team->name."</option>";
        }

        echo $equipos;
    }