<?php
    require_once "../model/realizar_consultas.php";
    class Competicion {
        
        protected array $anios = [];
        public function __construct(
            protected int $id,
            protected string $nombre,
            protected string $logo
        ) {}

        public function __get(string $propiedad) {
            return $this->$propiedad;
        }

        public function __set(string $propiedad, $valor) {
            $this->$propiedad = $valor;
        }

        public static function recogerCompeticion(int|string $idCompeticion): string|object {
        
            if (is_numeric($idCompeticion)) { // Compruebo si el id es un número

                $conexion = FrancisGolBD::establecerConexion();
                $consulta = "SELECT * FROM competicion WHERE idCompeticion = $idCompeticion"; // Recojo los datos de la competición 
                $resultado = $conexion->query($consulta);
        
                if (mysqli_num_rows($resultado) == 1) { // Si está en la BBDD
            
                    while($row = mysqli_fetch_assoc($resultado)) { 
                        
                        $competicion = new Competicion($row['idCompeticion'], $row['nombre'], $row['logo']); // Genera el objeto con los datos y lo devuelve
                    }

                } else { // Si no está en la BBDD

                    $competicion = realizarConsultaSinJson("leagues?id=$idCompeticion"); // Recoge los datos pero no crea el fichero JSON porque guardará los datos en la BBDD 

                    if (!empty($competicion)) {

                        $competicion = $competicion->response[0]->league;
                        $competicion = new Competicion($competicion->id, $competicion->name, $competicion->logo); // crea el objeto de la competición
                        $competicion->insertarCompeticion(); // Guarda la competición en la BBDD

                    } else {

                        return "";
                    }
                }

                return $competicion;
            }

            return "";
        }

        public function pintarCompeticion(): string { // Genera el HTML para visualizar la competición en distintas páginas

            $competicionesFavoritas = Competicion::recogerCompeticionFavorita();
            $claseFavorito = isset($_SESSION["usuario"]) && in_array($this->__get("id"), $competicionesFavoritas) ? "favorito" : ""; // Si está en favoritos añade la estrella amarilla y si no lo está la gris

            // Genera el HTML de la competición
            $datosCompeticion = '<div class="competicion_equipo competiciones">
                <a href="../controller/competicion_clasificacion.php?competicion='.$this->__get("id").'">
                    <div class="logo_competicion"><img src="'.$this->__get("logo").'" alt="Logo"></div>
                    <span>'.$this->__get("nombre").'</span>
                </a>';
            $datosCompeticion .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="competicion_'.$this->__get("id").'"></i>' : ''; // Muestra la estrella si la sesión está iniciada
            $datosCompeticion .= '</div><hr>';

            return $datosCompeticion;
        }

        public function insertarCompeticion() { // Guarda la Competición en la BBDD

            $conexion = FrancisGolBD::establecerConexion();

            // Recojo los datos de la competición
            $idCompeticion = $this->__get("id");
            $nombreCompeticion = $this->__get("nombre");
            $logoCompeticion = $this->__get("logo");
    
            $consulta = $conexion->prepare("INSERT INTO competicion (idCompeticion, nombre, logo)  VALUES (?, ?, ?)");
            
            try { // Intenta insertarlo en la BBDD 

                $consulta->bind_param("iss", $idCompeticion, $nombreCompeticion, $logoCompeticion);
                $consulta->execute();

            } catch (mysqli_sql_exception) {

                // Si la competición ya está insertado no hace nada
            }
        }

        public static function recogerEquipoCompeticiones(int $idEquipo): string|array {
        
            $equipoCompeticiones =  realizarConsulta("equipo_competiciones_$idEquipo", "leagues?team=$idEquipo", 604800); // Se recogen las competiciones en las que está el equipo 

            if (!empty($equipoCompeticiones)) {

                foreach ($equipoCompeticiones->response as $competicion) { // Se recorren las competiciones

                    $competicionesEquipo = new Competicion($competicion->league->id, $competicion->league->name, $competicion->league->logo); // se crea el objeto de la competición
    
    
                    foreach ($competicion->seasons as $anio) { // Se recorren los años disponibles del equipo
    
                        $competicionesEquipo->anios[] = $anio->year; // Se guardan los años disponibles de la competición
                    }
                    $competiciones[] = $competicionesEquipo; // Se guarda el objeto de la competición en un array
    
                }
    
                return $competiciones;
            }
            return "";
        }

        public static function pintarCompeticionesFavoritas(): string {
            
            $resultadoEquipos = "";
            $competicionesFavoritas = isset($_SESSION["usuario"]) ?  Competicion::recogerCompeticionFavorita() : [140, 39, 61, 78, 135, 2]; // Si la sesión está iniciada recoge las competiciones favoritas y si no está iniciada la sesión recoge el array de competiciones por defecto
        
            foreach ($competicionesFavoritas as $idCompeticion) { // Recorro los IDs de las competiciones
        
                $competicion = Competicion::recogerCompeticion($idCompeticion);  // Se recoge el objeto de la competición
                $resultadoEquipos .= $competicion->pintarCompeticion(); // HTML con el logo y nombre de la competición
            }

            return $resultadoEquipos;
        }

        public static function generarOptionsTemporadas(object $temporadasDisponibles): string {
            
            $anioActual = date("Y") - 1;
            $options = "";

            foreach ($temporadasDisponibles->response as $anio) { // Se recorren las temporadas disponibles

                if ($anioActual == $anio) { // Si el año es el actual se selecciona como predeterminado

                    $options .= "<option value='$anio' selected>$anio</option>";

                } else {

                    $options .= "<option value='$anio'>$anio</option>";
                }
            }

            return $options;
        }
        
        /* FUNCIONES COMPETICIÓN CLASIFICACIÓN */
        public function generarClasificacion(object $clasificacion): string { // Genera el HTML de la clasificación de una competición
    
            $tablaClasificacion = "";

            foreach ($clasificacion->response[0]->league->standings as $datosClasificacion) {

                $tablaClasificacion .= "<table><thead><tr>
                            <td></td>
                            <td>Club</td>
                            <td>Pts</td>
                            <td>Pj</td>
                            <td>V</td>
                            <td>E</td>
                            <td>D</td>
                            <td>GF</td>
                            <td>GC</td>
                            <td>GD</td></tr></thead><tbody>";
            
                foreach ($datosClasificacion as $equipo) {

                    $tablaClasificacion .= "<tr>
                        <td><div class='logo_competicion'><img src=".$equipo->team->logo." alt='escudo'></div></td>
                        <td>".$equipo->team->name."</td>
                        <td>".$equipo->points."</td>
                        <td>".$equipo->all->played."</td>
                        <td>".$equipo->all->win."</td>
                        <td>".$equipo->all->draw."</td>
                        <td>".$equipo->all->lose."</td>
                        <td>".$equipo->all->goals->for."</td>
                        <td>".$equipo->all->goals->against."</td>
                        <td>".$equipo->goalsDiff."</td>
                    </tr>";
                }
            
                $tablaClasificacion .= "</tbody></table>";
        
            }
        
            return $tablaClasificacion;
        }

        /* FUNCIONES COMPETICION EQUIPOS */
        public function generarEquiposCompeticion(object $equipos): string { // Se recogen los equipos de la competición

            $equiposFavoritos = Equipo::recogerEquiposFavorito();

            $todosLosEquipos = "";
        
            foreach ($equipos->response as $equipo) { // Se recorren los equipos de la competición
        
                $claseFavorito = isset($_SESSION['usuario']) && in_array($equipo->team->id, $equiposFavoritos) ? "favorito" : ""; // Si está en favoritos añade la estrella amarilla y si no lo está la gris

                // Genera el HTML de los equipos de la competición
                $todosLosEquipos .= '<div class="competicion_equipo competiciones">
                <a href="../controller/equipo_estadisticas.php?equipo='.$equipo->team->id.'">
                    <div class="logo_competicion"><img src="'.$equipo->team->logo.'" alt="Logo"></div>';
                $todosLosEquipos .= '<span>'.$equipo->team->name.'</span></a>';
                $todosLosEquipos .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="equipo_'.$equipo->team->id.'"></i>' : ''; // Si la sesión está iniciada añade la estrella al HTML
                $todosLosEquipos .= '</div><hr>';
            }
        
            return $todosLosEquipos;
        }

        /* FUNCIONES COMPETICIONES JORNADAS */
        public function generarJornadas(object $jornadas): array {
    
            $jornadasCompeticion = [];
            $fecha_actual = date('Y-m-d\TH:i:sP'); // Con formato de año, mes, día, hora, minuto, segundo y la zona horaria

            foreach ($jornadas->response as $partido) { // Recorre todas las jornadas
        
                $hora_partido = strtotime($partido->fixture->date);
                $fechaPartido = date('Y-m-d\TH:i:sP', $hora_partido); // Convierte la hora del partido a año, mes, día, hora, minuto, segundo y la zona horaria
                $hora_partido = date('H:i', $hora_partido); // Recojo la hora del partido en horas y minutos

                $ronda = $partido->league->round; // Nombre de la ronda
        
                // Genera el HTML de las jornadas de la copetición
                $partidosTotales = '
                    <div class="enfrentamiento_equipos">
                        <a href="../controller/partido_resumen.php?partido='.$partido->fixture->id.'">
                            <div class="equipo_local">
                                <img src="'.$partido->teams->home->logo.'" alt="Logo">
                                <span>'.$partido->teams->home->name.'</span>
                            </div>
                            <div class="resultado_hora">
                                <p>VS</p>';
                                if ($fecha_actual < $fechaPartido) { // Si la fecha del día del partido es mayor que la actual...
                                   
                                    $partidosTotales .= '<p>'.$hora_partido.'</p>'; // Muesto la hora de horas minutos

                                } else { // Si es menor, que significa que el partido comenzó o se jugó, muestro el resultado

                                    $partidosTotales .= '<p>'.$partido->goals->home.' - '.$partido->goals->away.'</p>';
                                }
        
                $partidosTotales .= '</div>
                            <div class="equipo_visitante">
                                <img src="'.$partido->teams->away->logo.'" alt="Logo">
                                <span>'.$partido->teams->away->name.'</span>
                            </div>
                        </a>
                    </div>
                    <hr class="separacion_partidos_negro">';

                // Si la jornada ya se creó en el array añade el HTML de la jornada a las jornadas que ya había y si no está lo añade
                isset($jornadasCompeticion[$ronda]) ? $jornadasCompeticion[$ronda] .= $partidosTotales : $jornadasCompeticion[$ronda] = $partidosTotales;

            }

            $contadorJornada = 1; // número de la jornada
            $opcionesPartidos = "";
            $jornadasPartidos = "";

            foreach ($jornadasCompeticion as $nombreRonda => $datosJornada) { // Recorre las jornadas de las competiciones

                $contadorJornada++;
                $opcionesPartidos .= "<option value='jornada_$contadorJornada'>$nombreRonda</option>"; // Crea los options para los select con los nombres de las jornadas
                $jornadasPartidos .= "<div class='ocultarjornada' id='jornada_$contadorJornada'>$datosJornada</div>"; // Crea el div con las jornadas 
        
            }

            return [$opcionesPartidos, $jornadasPartidos]; // Devuelve ambos datos
        }

        /* FUNCIONES FAVORITOS */
        public static function recogerCompeticionFavorita(): array {
        
            $arrayFavoritos = [];
    
            if (isset($_SESSION['usuario'])) {
                
                $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario
                $idUsuario = $usuario->__get("id");
        
                $conexion = FrancisGolBD::establecerConexion();
        
                $consulta = "SELECT * FROM competicion_favorita WHERE idUsuario = $idUsuario"; // Selecciono las competiciones favoritas del usuario
                $resultado = $conexion->query($consulta);
        
                while ($row = $resultado->fetch_assoc()) {
    
                    $arrayFavoritos[] = $row["idCompeticion"]; // Guardo en un array los IDs de las competiciones
                }
                
            }

            return $arrayFavoritos;
        }

        public static function insertarCompeticionFavorita(int $idCompeticion, int $idUsuario) {

            $conexion = FrancisGolBD::establecerConexion();
    
            // Guardo el ID de la competición con el id del usuario 
            $consulta = $conexion->prepare("INSERT INTO competicion_favorita (idUsuario, idCompeticion)  VALUES (?, ?)");
            $consulta->bind_param("ii", $idUsuario, $idCompeticion);
            $consulta->execute();
        }

        public static function eliminarCompeticionFavorita(int $idCompeticion, int $idUsuario): bool {

            $conexion = FrancisGolBD::establecerConexion();
    
            // Busco cuantas competiciones tiene en favoritos el usuario
            $consulta = "SELECT * FROM competicion_favorita WHERE idUsuario = $idUsuario";
            $resultado = $conexion->query($consulta);
            if (mysqli_num_rows($resultado) == 1) return false; // Si solo tiene 1 devuelvo false ya que como mínimo el usuario tiene que tener una competición favorita
    
            // Si tiene más de una competición favorita lo borra 
            $consulta = $conexion->prepare("DELETE FROM competicion_favorita WHERE idUsuario = ? AND idCompeticion = ?");
            $consulta->bind_param("ii", $idUsuario, $idCompeticion);
            return $consulta->execute();
        }
    }