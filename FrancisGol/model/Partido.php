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

    public static function recogerPartido(int|string $idPartido): string|object {

        $fecha_actual = date('Y-m-d\TH:i:sP'); // Con formato de año, mes, día, hora, minuto, segundo y la zona horaria

        $partido = realizarConsulta("datos_partido_$idPartido", "fixtures?id=$idPartido", 1800);

        if (empty($partido)) { return ""; }

        $partido = $partido->response[0];
        
        $hora_partido = strtotime($partido->fixture->date);
        $fechaPartido = date('Y-m-d\TH:i:sP', $hora_partido); // Convierte la hora del partido a año, mes, día, hora, minuto, segundo y la zona horaria
        $hora_partido = date('H:i', $hora_partido); // Recojo la hora del partido en horas y minutos

        if ($fecha_actual < $fechaPartido) { // Si la fecha del día del partido es mayor que la actual... 

            $resultadoHora = $hora_partido; // Muesto la hora de horas minutos

        } else { // Si es menor, que significa que el partido comenzó o se jugó, muestro el resultado

            $resultadoHora = $partido->goals->home.' - '.$partido->goals->away;
        }

        // Creo el objeto con todos los datos del partido
        $partido = new Partido($idPartido, $partido->teams->home->id, $partido->teams->away->id, $partido->teams->home->name, $partido->teams->away->name, $partido->teams->home->logo, $partido->teams->away->logo, $resultadoHora);

        return $partido;
    }

    public function pintarPartido(): string { // Genera el html del partido

        $datosPartido = "<div class='enfrentamiento_equipos'>
            <a href='../controller/equipo_estadisticas.php?equipo={$this->__get('idEquipoLocal')}'>
                <div class='equipo_local'>
                    <img src='{$this->__get('escudoEquipoLocal')}' alt='Logo' loading='lazy'>
                    <span>{$this->__get('nombreEquipoLocal')}</span>
                </div>
            </a>
            <div class='resultado_hora'>
                <p>VS</p>
                <p>{$this->__get('resultadoHora')}</p>
            </div>
            <a href='../controller/equipo_estadisticas.php?equipo={$this->__get('idEquipoVisitante')}'>
                <div class='equipo_visitante'>
                    <img src='{$this->__get('escudoEquipoVisitante')}' alt='Logo' loading='lazy'>
                    <span>{$this->__get('nombreEquipoVisitante')}</span>
                </div>
            </a>
        </div>";

        return $datosPartido;
    }

    /* FUNCIONES PARTIDO ALINEACIONES */
    public function pintarAlineacionesPartido(object $alineacionesPartido): string {

        $alineacionPrincipal = "";
        foreach ($alineacionesPartido->response as $clave => $alineacion) { // Recorre la alineación
    
            $alineacionPrincipal .= "<div class='alineacion_partido ".($clave == 1 ? "ocultar" : '' )."'>"; // La segunda alineación(visitante) la oculta
            $alineacionPrincipal .= "<div class='alineacion '>
                <p class='titulo_seccion'>Formación: {$alineacion->formation}</p>
                <div class='formacion_equipo formacion_{$alineacion->formation}'>"; 
            
            foreach ($alineacion->startXI as $jugador) { // Recorre todos los jugadores del once inicial

                $alineacionPrincipal .= 
                "<div class='jugador_".str_replace(":","_",$jugador->player->grid)."'>
                    <a href='../controller/jugador_datos.php?jugador=".$jugador->player->id."'>
                        <img src='https://media.api-sports.io/football/players/".$jugador->player->id.".png' alt='foto' loading='lazy'>
                        <p>{$jugador->player->name}</p>
                    </a></div>";
            }

            $alineacionPrincipal .= "</div></div>
                <p class='titulo_seccion'>Suplentes</p>
                <div class='seccion_negra jugadores_suplentes'>";

            foreach ($alineacion->substitutes as $suplente) { // Recorre los suplentes

                $alineacionPrincipal .= 
                "<div>
                    <a href='../controller/jugador_datos.php?jugador=".$suplente->player->id."'>
                    <img src='https://media.api-sports.io/football/players/".$suplente->player->id.".png' alt='foto' loading='lazy'>
                    <p>{$suplente->player->name}</p>
                </a></div>";
            }

            $alineacionPrincipal .= "</div></div></div>";

        }
    
        return $alineacionPrincipal;
    
    }

    /* FUNCIONES PARTIDO ESTADÍSTICAS */
    public function pintarEstadisticasPartido(object $estadisticasPartido): string {
 
        $tablaEstadisticas = "";
        // Tipos de estadísticas
        $tipoEstadistica = array("Tiros a puerta", "Tiros a fuera", "Tiros totales", "Tiros bloqueados", "Tiros dentro del área", "Tiros fuera del área", "Faltas cometidas", "Saques de esquina", "Fueras de juego", "Posesión del balón", "Tarjetas amarillas", "Tarjetas rojas", "Tiros parados", "Pases totales", "Pases efectivos", "% de pases", "Goles esperados", "Objetivos");
    
        foreach ($estadisticasPartido->response as $key => $equipo) { // Recorro los equipos
    
            // Genero dos tablas, uno con las estadísticas del equipo local y otro con el de los visitantes
            $tablaEstadisticas .= " <table class='tabla_datos ".($key == 1 ? "ocultar" : '' )."'>
            <thead>
                <tr>
                    <th colspan='2'>".$equipo->team->name."</th>
                </tr>
            </thead>
            <tbody>";
    
            foreach ($equipo->statistics as $key2 => $estadistica) { // Muestra las estadísticas cogiendo los títulos del array

                if ($key2 == 17) {
                    
                }
                $tablaEstadisticas .= "
                        <tr>
                            <td>".$tipoEstadistica[$key2]."</td>
                            <td>". $estadistica->value ."</td>
                        </tr>";
    
            }
    
            $tablaEstadisticas .= "</tbody>
            </table>";
        }
    
        return $tablaEstadisticas;
    }
    
    /* FUNCIONES PARTIDO RESUMEN */
    public function pintarResumenPartido(object $eventosPartido): string {

        $idEquipoLocal = $this->__get("idEquipoLocal");
        $idEquipoVisitante = $this->__get("idEquipoVisitante");

        if (empty($eventosPartido->response)) { return "<p class='parrafo_informacion'>El partido aún no ha comenzado</p>"; }
        
        foreach ($eventosPartido->response as $evento) { // Recorro los elementos

            $eventosEquipos[$evento->team->id][] = $evento; // guado todos los eventos de los equipos por separado con el id del equipo como clave

        }

        $eventosOrdenados = "";
        $id = $idEquipoLocal; // Cuando cambie el valor al id del equipo visitante se cerrará la tabla

        for ($i=0; $i < 2; $i++) { // Recorro dos veces

            $eventosEquipo = [];
            $eventosOrdenados .= "<div>
            <h3 class='titulo_informacion'>".$eventosEquipos[$id][0]->team->name."</h3>";

            foreach ($eventosEquipos[$id] as $evento) { // Recorro los eventos y genero el HTML

                $eventosPartido = "";
                $minuto = $evento->time->elapsed + $evento->time->extra;

                $eventosPartido .= "
                <div class='evento'>
                    <div class='icono_minuto'>
                    <p class='minuto'>".$minuto."'</p>
                ";

                $eventosPartido .= match ($evento->type) {
                    "Goal" => "<i class='fa-solid fa-futbol icono_evento verde'></i>",
                    "Var" => $evento->detail == "Goal confirmed" ? "<i class='fa-solid fa-futbol icono_evento verde'></i>" : "<i class='fa-solid fa-futbol icono_evento rojo'></i>" ,
                    "NoGoal" => "<div class='icono_evento gol_anulado'>
                                    <i class='fa-solid fa-futbol'></i>
                                    <i class='fa-solid fa-xmark'></i>
                                    </div>",
                    "Card" => $evento->detail == "Yellow Card" ? "<div class='icono_evento'><div class='tarjeta_amarilla'></div></div>" : "<div class='icono_evento'><div class='tarjeta_roja'></div></div>" ,
                    "subst" => "<i class='fa-solid fa-arrows-rotate icono_evento'></i>",
                    default => $evento->detail
                };
                $eventosPartido .= "</div>";
                $eventosPartido .= match ($evento->type) {
                    "subst" => "<div class='nombre_evento cambio'>
                                    <p class='rojo'>".$evento->player->name."</p>
                                    <p class='verde'>".$evento->assist->name."</p>
                                </div>",
                    default => "<p class='nombre_evento'>".$evento->player->name."</p>"
                };

                $eventosPartido .= "</div>";

                isset($eventosEquipo[$minuto]) ? $eventosEquipo[$minuto] .= $eventosPartido : $eventosEquipo[$minuto] = $eventosPartido; // Voy guardando los eventos en los minutos, si el minuto ya está creado lo añade a lo anterior y si no lo está lo añade como nuevo
                    
            }

            ksort($eventosEquipo); // Ordeno los minutos de menor a mayor

            foreach ($eventosEquipo as $evento) { // Recorro los eventos 
                $eventosOrdenados .= $evento;
            }

            $eventosOrdenados .= $id == $idEquipoLocal ? "</div><hr>" : "</div>"; // La primera vez cierra el div y añade un hr y la segunda cierra solo el div
            $id = $idEquipoVisitante; // Para que seleccione los datos del otro equipo
            
        }
        return $eventosOrdenados;
    }

    /* FUNCIONES PARTIDOS */
    public static function pintarPartidos(object $partidos): string {
    
        $partidosEquiposFavoritos = [];
        $todosLosPartidos = "";
        $fecha_actual = date('Y-m-d\TH:i:sP'); // Con formato de año, mes, día, hora, minuto, segundo y la zona horaria

        $equiposFavoritos = isset($_SESSION["usuario"]) ? Equipo::recogerEquiposFavorito() : [530, 529, 541, 157, 50, 85, 10139]; // Si la sesión está iniciada recoge los equipos favoritos y si no está iniciada la sesión recoge el array de equipos por defecto

        foreach ($partidos->response as $partido) { // Recorro todos los partidos
    
            $hora_partido = strtotime($partido->fixture->date);
            $fechaPartido = date('Y-m-d\TH:i:sP', $hora_partido); // Convierte la hora del partido a año, mes, día, hora, minuto, segundo y la zona horaria
            $hora_partido = date('H:i', $hora_partido); // Recojo la hora del partido en horas y minutos
            
            // Recojo los IDs del partido
            $idEquipoLocal = $partido->teams->home->id;
            $idEquipoVisitante = $partido->teams->away->id;
            $idPartido = $partido->fixture->id;
            
            $partidosDeUnaLiga = '
                <div class="enfrentamiento_equipos">
                    <a href="../controller/partido_resumen.php?partido='.$idPartido.'">
                        <div class="equipo_local">
                            <img src="'.$partido->teams->home->logo.'" alt="Logo" loading="lazy">
                            <span>'.$partido->teams->home->name.'</span>
                        </div>
                        <div class="resultado_hora">
                            <p>VS</p>';
                            
                            if ($fecha_actual < $fechaPartido) { // Si la fecha del día del partido es mayor que la actual...
                                
                                $partidosDeUnaLiga .= '<p>'.$hora_partido.'</p>'; // Muesto la hora de horas minutos

                            } else { // Si es menor, que significa que el partido comenzó o se jugó, muestro el resultado
    
                                $partidosDeUnaLiga .= '<p>'.$partido->goals->home.' - '.$partido->goals->away.'</p>';
                            }
    
            $partidosDeUnaLiga .= '</div>
                        <div class="equipo_visitante">
                            <img src="'.$partido->teams->away->logo.'" alt="Logo" loading="lazy">
                            <span>'.$partido->teams->away->name.'</span>
                        </div>
                    </a>
                </div>
                <hr class="separacion_partidos">';
    
            $idLigaActual = $partido->league->id;
            $datosLiga[$idLigaActual] = [$partido->league->logo, $partido->league->name]; // Guardo los datos de la competición
            $partidosPorLiga[$idLigaActual][$idPartido] = $partidosDeUnaLiga; // Gurfo el HTML generado de los partidos en un array doble en el id de la liga con el id del partido
            
            if (in_array($idEquipoLocal, $equiposFavoritos) || in_array($idEquipoVisitante, $equiposFavoritos)) { // Si el equipo visitante o el local están en favoritos...
                
                $partidosEquiposFavoritos[$idPartido] = $idLigaActual; // Guardo el id de la liga en el id del partido
            }

        }

        $competicionesFavoritas = isset($_SESSION["usuario"]) ? Competicion::recogerCompeticionFavorita() : [140, 39, 61, 78, 135, 2, 3] ; // Si la sesión está iniciada recoge las competiciones favoritas y si no está iniciada la sesión recoge el array de competiciones por defecto

        foreach ($partidosPorLiga as $idLiga => $partidosLiga) { // Recorro los partidos recogidos anteriormente 

            if (in_array($idLiga, $competicionesFavoritas) || in_array($idLiga, $partidosEquiposFavoritos)) { // Si la competición está en favoritos o en el array de equipos favoritos...
                    
                // Genero el HTML de la competición
                $todosLosPartidos .= '
                <section class="seccion_negra">
                    <div class="competicion_equipo">
                        <a href="../controller/competicion_clasificacion.php?competicion='.$idLiga.'">
                            <div class="logo_competicion"><img src="'.$datosLiga[$idLiga][0].'" alt="Logo" loading="lazy"></div>
                            <span>'.$datosLiga[$idLiga][1].'</span>
                        </a>';
                $favorito = in_array($idLiga, $competicionesFavoritas) ? "favorito" : ""; // Si la liga está en favoritos muestro la estrella amarilla, si no lo está la gris  
                $todosLosPartidos .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella '.$favorito.'" id="competicion_'.$idLiga.'"></i>' : "";        

                $todosLosPartidos .= '</div><hr>';

                // Cuando se crea la cabecera añado todos los partidos si la competición está en favoritos o añado solo los partidos de los equipos favoritos
                foreach ($partidosLiga as $idPartido => $partidoLiga) {

                    if (in_array($idLiga, $competicionesFavoritas)) { // Si el id pertenece a una liga favorita...

                        $todosLosPartidos .= $partidoLiga; // Añade el HTML del partido 

                    } else {

                        if (array_key_exists($idPartido, $partidosEquiposFavoritos)) { // Si está el partido en el array de los equipos favoritos
                           
                            $todosLosPartidos .= $partidoLiga; // Añade el HTML del partido 
                        }

                    }
                    
                }
        
                $todosLosPartidos .= "</section>";
            }
        }
    
        return empty($todosLosPartidos) ? "No hay partidos disponibles" : $todosLosPartidos;
    }

    public static function generarFechasPartidos(): string {
    
        $fecha_actual = date("Y-m-d");
    
        $fechas = [];
    
        for ($i=-4; $i < 5; $i++) { // Genero 4 días atrás, hoy y cuatro días después
    
            array_push($fechas, date("Y-m-d", strtotime("$i day", strtotime($fecha_actual))));
    
        }
    
        // genero el HTML del calendario
        $fechas_partidos = '<i class="fa-regular fa-calendar"><input type="date" class="inputCalendario"></i>';
        $fechas_partidos .= '';
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[0]."'>".substr($fechas[0],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[1]."'>".substr($fechas[1],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[2]."'>".substr($fechas[2],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[3]."'>Ayer</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[4]."'>Hoy</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[5]."'>Mañana</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[6]."'>".substr($fechas[6],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[7]."'>".substr($fechas[7],8)."</a><hr>";
        $fechas_partidos .= "<a href='../controller/partidos.php?fecha=".$fechas[8]."'>".substr($fechas[8],8)."</a>";
        $fechas_partidos .= '<i class="fa-regular fa-calendar"><input type="date" class="inputCalendario"></i>';
        $fechas_partidos .= '';
        
        return $fechas_partidos;
    }
}
