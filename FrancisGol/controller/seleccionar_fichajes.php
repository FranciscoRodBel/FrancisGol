<?php
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";


    if (isset($_GET['equipo'])) {

        if (!empty($_GET['equipo'])) {
            
            $idEquipo = $_GET['equipo'];
            $fichajesEquipo = realizarConsulta("fichajes_$idEquipo", "transfers?team=$idEquipo", 86400); 

            $fichajes = Equipo::pintarFichajesEquipo($fichajesEquipo);

            echo $fichajes;
        } else {

            $fichajes = "<p>No se encontró el equipo</p>";
        }

    }