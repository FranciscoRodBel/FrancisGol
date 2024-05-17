<?php
    function crearOpcionesPaises() {

        $paises = realizarConsulta("paises", "countries", 31536000);

        $opciones = "";
        foreach ($paises->response as $pais) {

            if ($pais->name == "Spain") {

                $opciones .= "<option value='".$pais->code."' selected>".$pais->name."</option>";
            } else {
                $opciones .= "<option value='".$pais->code."'>".$pais->name."</option>";
            }
        }

        return $opciones;
    }