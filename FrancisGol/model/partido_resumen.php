<?php
    function pintarResumenPartido($eventosPartido, $idEquipoLocal, $idEquipoVisitante) {

        if (!empty($eventosPartido->response)) {
            foreach ($eventosPartido->response as $evento) {

                $eventosEquipos[$evento->team->id][] = $evento;
    
            }
    
            $resumenPartido = "";
            $id = $idEquipoLocal;
    
            for ($i=0; $i < 2; $i++) { 
    
                $resumenPartido .= "<div>
                <h3 class='titulo_informacion'>".$eventosEquipos[$id][0]->team->name."</h3>";
    
                foreach ($eventosEquipos[$id] as $evento) {
    
                    $resumenPartido .= "
                    <div class='evento'>
                        <p class='minuto'>".$evento->time->elapsed."'</p>
                    ";
    
                    $resumenPartido .= match ($evento->type) {
                        "Goal" => "<i class='fa-solid fa-futbol icono_evento'></i>",
                        "NoGoal" => "<div class='icono_evento gol_anulado'>
                                        <i class='fa-solid fa-futbol'></i>
                                        <i class='fa-solid fa-xmark'></i>
                                     </div>",
                        "Card" => $evento->detail == "Yellow Card" ? "<div class='icono_evento'><div class='tarjeta_amarilla'></div></div>" : "<div class='icono_evento'><div class='tarjeta_roja'></div></div>" ,
                        "subst" => "<i class='fa-solid fa-arrows-rotate icono_evento'></i>",
                        default => $evento->detail
                    };
    
                    $resumenPartido .= match ($evento->type) {
                        "subst" => "<div class='nombre_evento cambio'>
                                        <p>".$evento->player->name."</p>
                                        <p>".$evento->assist->name."</p>
                                    </div>",
                        default => "<p class='nombre_evento'>".$evento->player->name."</p>"
                    };
    
                    $resumenPartido .= "</div>";
                }
    
                $resumenPartido .= $id == $idEquipoLocal ? "</div><hr>" : "</div>";
    
                $id = $idEquipoVisitante;
                
            }
        } else {
            $resumenPartido = "<p>El partido aún no ha comenzado</p>";
        }


        return $resumenPartido;
    }