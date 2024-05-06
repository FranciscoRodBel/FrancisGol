<?php
class Partido {
    
    public function __construct(
        protected int $id,
        protected string $idEquipoLocal,
        protected string $idEquipoVisitante,
        protected string $nombreEquipoLocal,
        protected string $nombreEquipoVisitante,
        protected string $escudoEquipoLocal,
        protected string $escudoEquipoVisitante,
        protected string $resultadoHora
    ) {}

    public function __get(string $propiedad) {
        return $this->$propiedad;
    }

    public function __set(string $propiedad, $valor) {
        $this->$propiedad = $valor;
    }

    public static function recogerPartido($idPartido) {
        
        $partido = realizarConsulta("datos_partido_$idPartido", "fixtures?id=$idPartido", 86400);
        $partido = $partido->response[0];
        
        $hora_partido = strtotime($partido->fixture->date);
        $hora_partido = date('H:i', $hora_partido);

        if (date('H:i') > $hora_partido) {

            $resultadoHora = $hora_partido;
        } else {

            $resultadoHora = $partido->goals->home.' - '.$partido->goals->away;
        }

        $partido = new Partido($idPartido, $partido->teams->home->id, $partido->teams->away->id, $partido->teams->home->name, $partido->teams->away->name, $partido->teams->home->logo, $partido->teams->away->logo, $resultadoHora);

        return $partido;
    }

    public function pintarPartido() {

        $datosPartido = "<div class='enfrentamiento_equipos'>
            <a href='../controller/equipo_estadisticas.php?equipo={$this->__get('idEquipoLocal')}'>
                <div class='equipo_local'>
                    <img src='{$this->__get('escudoEquipoLocal')}' alt='Logo'>
                    <span>{$this->__get('nombreEquipoLocal')}</span>
                </div>
            </a>
            <div class='resultado_hora'>
                <p>VS</p>
                <p>{$this->__get('resultadoHora')}</p>
            </div>
            <a href='../controller/equipo_estadisticas.php?equipo={$this->__get('idEquipoVisitante')}'>
                <div class='equipo_visitante'>
                    <img src='{$this->__get('escudoEquipoVisitante')}' alt='Logo'>
                    <span>{$this->__get('nombreEquipoVisitante')}</span>
                </div>
            </a>
        </div>";

        return $datosPartido;
    }

    /* FUNCIONES PARTIDO ALINEACIONES */
    public function pintarAlineacionesPartido($alineacionesPartido) {
        // print_r($alineacionesPartido);
    
        // echo "<h3>Alineaciones del partido: </h3>";
    
        // foreach ($alineacionesPartido->response as $alineacion) {
    
        //     echo "<h3>Alineación de ". $alineacion->team->name ."</h3>";
        //     echo "<p>Formación: ". $alineacion->formation ."</p>";
        //     echo "<h4>Titulares</h4>";
        //     echo "<ul>";
    
        //     foreach ($alineacion->startXI as $jugador) {
        //         echo "<li>{$jugador->player->name} ({$jugador->player->pos}) - {$jugador->player->grid}</li>";
        //     }
    
        //     echo "</ul>";
    
        //     if (!empty($alineacion->substitutes)) {
    
        //         echo "<h4>Suplentes</h4>";
        //         echo "<ul>";
    
        //         foreach ($alineacion->substitutes as $suplente) {
        //             echo "<li>{$suplente->player->name} ({$suplente->player->pos})</li>";
        //         }
    
        //         echo "</ul>";
        //     }
        // }
        $alineacionPrincipal = "";
        foreach ($alineacionesPartido->response as $alineacion) {
    
            $alineacionPrincipal .= "<p>Formación: {$alineacion->formation}</p>";
            $alineacionPrincipal .= "<div class='alineacion'><div class='formacion_equipo formacion_{$alineacion->formation}'>"; 
            foreach ($alineacion->startXI as $jugador) {
                $alineacionPrincipal .= 
                "<div class='jugador_".str_replace(":","_",$jugador->player->grid)."'>
                    <img src='../view/assets/images/logo.png' alt='foto'>
                    <p>{$jugador->player->name}</p>
                </div>";
            }
            $alineacionPrincipal .= "</div></div>";
        }
    
        return $alineacionPrincipal;
    
    }

    /* FUNCIONES PARTIDO ESTADÍSTICAS */
    public function pintarEstadisticasPartido($estadisticasPartido) {
 
        $tablaEstadisticas = "";
        $tipoEstadistica = array("Tiros a puerta", "Tiros a fuera", "Tiros totales", "Tiros bloqueados", "Tiros dentro del área", "Tiros fuera del área", "Faltas cometidas", "Saques de esquina", "Fueras de juego", "Posesión del balón", "Tarjetas amarillas", "Tarjetas rojas", "Tiros parados", "Pases totales", "Pases efectivos", "% de pases", "Goles esperados");
    
        foreach ($estadisticasPartido->response as $key => $equipo) {
            // echo "<h3>Estadísticas ".$equipo->team->name." </h3>";
            // echo "Id {$equipo->team->name}: {$equipo->team->id}<br>";
            // echo "<img src=".$equipo->team->logo." alt='logo'><br>";
            // echo "<h4>Estadísticas</h4>";
    
            $tablaEstadisticas .= " <table class='tabla_datos'>
            <thead>
                <tr>
                    <th colspan='2'>".$equipo->team->name."</th>
                </tr>
            </thead>
            <tbody>";
    
            foreach ($equipo->statistics as $key => $estadistica) {
                // echo $estadistica->type.": {$estadistica->value} <br>";
    
                $tablaEstadisticas .= "
                        <tr>
                            <td>".$tipoEstadistica[$key]."</td>
                            <td>". $estadistica->value ."</td>
                        </tr>";
    
            }
    
            $tablaEstadisticas .= "</tbody>
            </table>";
        }
    
        return $tablaEstadisticas;
    }
    
    /* FUNCIONES PARTIDO RESUMEN */
    public function pintarResumenPartido($eventosPartido) {

        $idEquipoLocal = $this->__get("idEquipoLocal");
        $idEquipoVisitante = $this->__get("idEquipoVisitante");

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

    /* FUNCIONES PARTIDOS */
    public static function pintarPartidos($partidos) {
    
        $todosLosPartidos = "";
    
        foreach ($partidos->response as $partido) {
    
            $hora_partido = strtotime($partido->fixture->date);
            // $hora_partido = strtotime('+2 hours', $hora_partido);
            $hora_partido = date('H:i', $hora_partido);
            
            $partidosDeUnaLiga = '
                <div class="enfrentamiento_equipos">
                    <a href="../controller/partido_resumen.php?partido='.$partido->fixture->id.'">
                        <div class="equipo_local">
                            <img src="'.$partido->teams->home->logo.'" alt="Logo">
                            <span>'.$partido->teams->home->name.'</span>
                        </div>
                        <div class="resultado_hora">
                            <p>VS</p>';
                            if (date('H:i') > $hora_partido) {
    
                                $partidosDeUnaLiga .= '<p>'.$hora_partido.'</p>';
                            } else {
    
                                $partidosDeUnaLiga .= '<p>'.$partido->goals->home.' - '.$partido->goals->away.'</p>';
                            }
    
            $partidosDeUnaLiga .= '</div>
                        <div class="equipo_visitante">
                            <img src="'.$partido->teams->away->logo.'" alt="Logo">
                            <span>'.$partido->teams->away->name.'</span>
                        </div>
                    </a>
                </div>
                <hr class="separacion_partidos">';
    
            $idLigaActual = $partido->league->id;
            $datosLiga[$idLigaActual] = [$partido->league->logo, $partido->league->name];
            $partidosPorLiga[$idLigaActual][] = $partidosDeUnaLiga;
    
        }

        $competicionesFavoritas = !isset($_SESSION["usuario"]) ? [140, 39, 61, 78, 71, 2] : (Competicion::recogerCompeticionFavorita());

        foreach ($partidosPorLiga as $idLiga => $partidosLiga) {

            if (in_array($idLiga, $competicionesFavoritas)) {
                    
                $todosLosPartidos .= '
                <section class="seccion_negra">
                    <div class="competicion_equipo">
                        <a href="../controller/competicion_clasificacion.php?competicion='.$idLiga.'">
                            <img src="'.$datosLiga[$idLiga][0].'" alt="Logo">
                            <span>'.$datosLiga[$idLiga][1].'</span>
                        </a>';
                $todosLosPartidos .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella favorito" id="competicion_'.$idLiga.'"></i>' : "";        
                $todosLosPartidos .= '</div><hr>';

                foreach ($partidosLiga as $partidoLiga) {
                    $todosLosPartidos .= $partidoLiga;
                }
        
                $todosLosPartidos .= "</section>";
            }
        }
    
        return empty($todosLosPartidos) ? "No hay partidos disponibles" : $todosLosPartidos;
    }

    public static function generarFechasPartidos() {
    
        $fecha_actual = date("Y-m-d");
    
        $fechas = [];
    
        for ($i=-4; $i < 5; $i++) { 
    
            array_push($fechas, date("Y-m-d", strtotime("$i day", strtotime($fecha_actual))));
    
        }
    
        $fechas_partidos = "<a href='../controller/partidos.php?fecha=".$fechas[0]."'>".substr($fechas[0],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[1]."'>".substr($fechas[1],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[2]."'>".substr($fechas[2],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[3]."'>Ayer</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[4]."'>Hoy</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[5]."'>Mañana</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[6]."'>".substr($fechas[6],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[7]."'>".substr($fechas[7],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[8]."'>".substr($fechas[8],8)."</a>";
    
        return $fechas_partidos;
    
    }
}