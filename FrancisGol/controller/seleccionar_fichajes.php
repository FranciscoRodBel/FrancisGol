<?php
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/realizar_consultas.php";


    if (isset($_GET['equipo']) && !empty($_GET['equipo'])) {
            
            $idEquipo = $_GET['equipo'];
            $fichajesEquipo = realizarConsulta("fichajes_$idEquipo", "transfers?team=$idEquipo", 604800); 

            if (!empty($fichajesEquipo)) {

                echo Equipo::pintarFichajesEquipo($fichajesEquipo);
            }

    } else {

        echo "<p>No se encontró el equipo</p>";
    }