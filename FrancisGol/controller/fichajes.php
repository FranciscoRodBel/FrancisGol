<?php
    require_once "../model/Usuario.php";
    require_once "../model/Equipo.php";
    require_once "../model/paises.php";
    require_once "../model/realizar_consultas.php";

    $titulo = "FrancisGol - Fichajes";
    $lista_css = ["registro_inicio.css"];

    $paises = crearOpcionesPaises(); // Se generan las opciones para el select que se utiliza para seleccionar las competiciones

    $fichajes = "<p class='parrafo_informacion'>Seleccione un equipo.</p>"; // Si algún dato está vacío se muestra este mensaje

    if (isset($_POST['enviar']) && isset($_POST['equipos_competicion'])) { // Si se envia el id del Equipo
        
        if (!empty($_POST['equipos_competicion'])) { // Si el id del Equipo no está vacío

            $idEquipo = $_POST['equipos_competicion'];
            $fichajesEquipo = realizarConsulta("fichajes_$idEquipo", "transfers?team=$idEquipo", 86400); // Se recogen los fichajes del equipo

            if (!empty($fichajesEquipo)) {

                $fichajes = Equipo::pintarFichajesEquipo($fichajesEquipo); // Se genera el HTML con todos los fichajes

            } else {

                $fichajes = "<p class='parrafo_informacion'>No se encontró el equipo.</p>";
            }
        }

    } elseif (isset($_SESSION["usuario"])) { // Si la sesión está inciada...

        $equiposFavoritos = Equipo::recogerEquiposFavorito(); 

        if (!empty($equiposFavoritos)) {

            $fichajes = Equipo::generarSelectEquipos($equiposFavoritos); // Permite el usuario ver los fichajes de sus equipos favoritos
        }
    }

    include '../view/templates/head.php';
    include '../view/templates/header.php';
    include '../view/templates/nav.php';
    include '../view/fichajes.php';
    include '../view/templates/footer.php';
