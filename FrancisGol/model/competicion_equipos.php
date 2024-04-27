<?php

function generarEquipos($equipos) {

    $todosLosEquipos = "";

    foreach ($equipos->response as $equipo) {

        $todosLosEquipos .= "<a href='../controller/equipo_estadisticas.php?equipo={$equipo->team->id}'><div>";
            $todosLosEquipos .= "<img src=".$equipo->team->logo." alt='logo competición'>";
            $todosLosEquipos .= "<p>".$equipo->team->name."</p>";
            $todosLosEquipos .= '<i class="fa-solid fa-star icono_estrella"></i>';
        $todosLosEquipos .= "</div></a>";
    }

    return $todosLosEquipos;
}