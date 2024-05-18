<?php
    require_once "../model/Usuario.php";
    require_once "../model/realizar_consultas.php";
    // require_once "../model/Competicion.php"; // Descomentar para insertar en la BBDD todas las competiciones
    
    if (isset($_POST['query']) && !empty($_POST['query'])) {

        $resultado = realizarConsulta("competiciones", "leagues", 7776000); // Se recogen todas las competiciones existentes cada 3 meses
        $competiciones_pais = "";

        if (!empty($resultado)) {

            $codigoPais = $_POST['query'];

            foreach ($resultado->response as $liga) { // Se recorren todas las competiciones y se generan los options para el select para seleccionar equipos

                // $competicion = new Competicion($liga->league->id, $liga->league->name, $liga->league->logo); // Descomentar para insertar en la BBDD todas las competiciones
                // $competicion->insertarCompeticion(); // Descomentar para insertar en la BBDD todas las competiciones

                $competicion = "<option value='".$liga->league->id."'>".$liga->league->name."</option>";

                if ($liga->country->code == $codigoPais) { // Añade para que se muestren todas las competiciones del país seleccionado

                    $competiciones_pais .= $competicion;
                }
            }
        }

        echo $competiciones_pais;

    } else if (isset($_GET["texto"]) && !empty($_GET["texto"])) { // Esta parte es para el buscador de la página de buscar

        $resultado = realizarConsulta("competiciones", "leagues", 7776000); // Se recogen todas las competiciones existentes cada 3 meses
        $competiciones_pais = "";

        if (!empty($resultado)) {

            $texto = $_GET['texto'];
            $pattern = "/$texto/i"; // Tiene que coincidir lo que busca el usuario con la liga - pais que se busca

            foreach ($resultado->response as $liga) { // Se recorren todas las competiciones y se generan los options para el select para seleccionar equipos

                $paisCompeticion = $liga->country->code == null ? $liga->country->name : $liga->country->code; // Si la competición no pertenece a un páis se selecciona un dato distinto

                if (preg_match($pattern, $liga->league->name." - ".$paisCompeticion)) { // Se comprueba si la competición cumple con lo buscado

                    $competicion = "<option data-idCompeticion='".$liga->league->id."'>".$liga->league->name." - $paisCompeticion </option>"; // Genera las opciones con las competiciones encontradas
                    $competiciones_pais .= $competicion; 
                }
            }
        }

        echo $competiciones_pais;
    }