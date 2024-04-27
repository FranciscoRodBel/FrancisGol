<?php

function pintarFichajesEquipo($fichajesEquipo) {

    $fichajes = "";



    foreach ($fichajesEquipo->response as $key => $jugador) {

        foreach ($jugador->transfers as $key => $datoFichaje) {

            if (preg_match("/^2024/", $datoFichaje->date) || preg_match("/^2023/", $datoFichaje->date)) {
    
                // $jugador->player->id
                $fichajes .= "<div>
                    <div class='datos_fichaje'>
                        <a href=''>".$jugador->player->name."</a>
                        <hr>
                        <p>".$datoFichaje->date."</p>
                    </div>
                    <div class='fichaje_equipos'>
                        <div class='equipo_fichaje'>
                            <a href=''>
                                <img src='".$datoFichaje->teams->out->logo."' alt='Logo'>
                                <p>".$datoFichaje->teams->out->name."</p>
                            </a>
                        </div>
                        <div class='tipo_fichaje'><p>";
                            $fichajes .= match ($datoFichaje->type) {
                                "Loan" => "Cedido",
                                "Free" => "Gratis",
                                "N/A" => "",
                                default => $datoFichaje->type
                            };
                            $fichajes .= "</p>
                            <p>
                                <i class='fa-sharp fa-solid fa-chevron-right'></i>
                                <i class='fa-sharp fa-solid fa-chevron-right'></i>
                                <i class='fa-sharp fa-solid fa-chevron-right'></i>
                            </p>
                        </div>
                        <div class='equipo_fichaje'>
                            <a href=''>
                                <img src='".$datoFichaje->teams->in->logo."' alt='Logo'>
                                <p>".$datoFichaje->teams->in->name."</p>
                            </a>
                        </div>
                    </div>".
                "</div>";
    
            }
        }
    }

    return $fichajes;
}