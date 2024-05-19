<?php
    function crearOpcionesPaises(): string {

        $paises = realizarConsulta("paises", "countries", 31536000); // Recoge los paises disponilbes cada año
        $opciones = "";

        if (!empty($paises)) {

            foreach ($paises->response as $pais) { // Recorre los paises y genera los options
    
                if ($pais->name == "Spain") {
    
                    $opciones .= "<option value='".$pais->code."' selected>".$pais->name."</option>";
                } else {
                    $opciones .= "<option value='".$pais->code."'>".$pais->name."</option>";
                }
            }
        }
        return $opciones;
    }