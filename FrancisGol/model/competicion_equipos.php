<?php

function generarEquipos($equipos) {

    $todosLosEquipos = "";

    foreach ($equipos->response as $equipo) {

        $todosLosEquipos .= "<div>";
            $todosLosEquipos .= "<img src=".$equipo->team->logo." alt='logo competición'>";
            $todosLosEquipos .= "<p>".$equipo->team->name."</p>";
            $todosLosEquipos .= '<i class="fa-solid fa-star icono_estrella"></i>';
        $todosLosEquipos .= "</div>";
    }

    return $todosLosEquipos;
}