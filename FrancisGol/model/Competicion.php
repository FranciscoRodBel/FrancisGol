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

        public static function recogerCompeticion($idCompeticion) {
        
            if (is_numeric($idCompeticion)) {

                $conexion = FrancisGolBD::establecerConexion();
                $consulta = "SELECT * FROM competicion WHERE idCompeticion = $idCompeticion";
                $resultado = $conexion->query($consulta);
        
                if (mysqli_num_rows($resultado) == 1) {
            
                    while($row = mysqli_fetch_assoc($resultado)) {
                        
                        $competicion = new Competicion($row['idCompeticion'], $row['nombre'], $row['logo']);
                    }

                } else {

                    $competicion = realizarConsultaSinJson("leagues?id=$idCompeticion");

                    if ($competicion->results != 0) {

                        $competicion = $competicion->response[0]->league;
                        $competicion = new Competicion($competicion->id, $competicion->name, $competicion->logo);
                        $competicion->insertarCompeticion();

                    } else {

                        return "";
                    }
                }

                return $competicion;
            }

            return "";
        }

        public function pintarCompeticion() {

            $competicionesFavoritas = Competicion::recogerCompeticionFavorita();
            $claseFavorito = isset($_SESSION["usuario"]) && in_array($this->__get("id"), $competicionesFavoritas) ? "favorito" : "";

            $datosCompeticion = '<div class="competicion_equipo competiciones">
                <a href="../controller/competicion_clasificacion.php?competicion='.$this->__get("id").'">
                    <div class="logo_competicion"><img src="'.$this->__get("logo").'" alt="Logo"></div>
                    <span>'.$this->__get("nombre").'</span>
                </a>';
            $datosCompeticion .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="competicion_'.$this->__get("id").'"></i>' : '';   
            $datosCompeticion .= '</div><hr>';

            return $datosCompeticion;
        }

        public function insertarCompeticion() {
            $conexion = FrancisGolBD::establecerConexion();

            $idCompeticion = $this->__get("id");
            $nombreCompeticion = $this->__get("nombre");
            $logoCompeticion = $this->__get("logo");
    
            $consulta = $conexion->prepare("INSERT INTO competicion (idCompeticion, nombre, logo)  VALUES (?, ?, ?)");
            
            try {

                $consulta->bind_param("iss", $idCompeticion, $nombreCompeticion, $logoCompeticion);
                $consulta->execute();

            } catch (mysqli_sql_exception) {
                // Si la competición ya está insertado no hace nada
            }
        }

        public static function recogerEquipoCompeticiones($idEquipo) {
        
            $equipoCompeticiones =  realizarConsulta("equipo_competiciones_$idEquipo", "leagues?team=$idEquipo", 86400); 

            if (!empty($equipoCompeticiones)) {

                foreach ($equipoCompeticiones->response as $competicion) {

                    $competicionesEquipo = new Competicion($competicion->league->id, $competicion->league->name, $competicion->league->logo);
    
    
                    foreach ($competicion->seasons as $anio) {
    
                        $competicionesEquipo->anios[] = $anio->year;
                    }
                    $competiciones[] = $competicionesEquipo;
    
                }
    
                return $competiciones;
            }
            return "";
        }

        public static function pintarCompeticionesFavoritas() {
            
            $resultadoEquipos = "";
            $competicionesFavoritas = isset($_SESSION["usuario"]) ?  Competicion::recogerCompeticionFavorita() : [140, 39, 61, 78, 71, 2];
        
            foreach ($competicionesFavoritas as $idCompeticion) {
        
                $competicion = Competicion::recogerCompeticion($idCompeticion);
                $resultadoEquipos .= $competicion->pintarCompeticion();
            }

            return $resultadoEquipos;
        }

        public static function generarOptionsTemporadas($temporadasDisponibles) {
            
            $anioActual = date("Y") - 1;
            $options = "";

            foreach ($temporadasDisponibles->response as $anio) {

                if ($anioActual == $anio) {

                    $options .= "<option value='$anio' selected>$anio</option>";

                } else {

                    $options .= "<option value='$anio'>$anio</option>";
                }

            }

            return $options;
        }
        
        /* FUNCIONES COMPETICIÓN CLASIFICACIÓN */
        public function generarClasificacion($clasificacion) {
    
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
                        <td><img src=".$equipo->team->logo." alt='escudo'></td>
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
        public function generarEquiposCompeticion($equipos) {

            $equiposFavoritos = Equipo::recogerEquiposFavorito();

            $todosLosEquipos = "";
        
            foreach ($equipos->response as $equipo) {
        
                $claseFavorito = isset($_SESSION['usuario']) && in_array($equipo->team->id, $equiposFavoritos) ? "favorito" : "";

                $todosLosEquipos .= '<div class="competicion_equipo competiciones">
                <a href="../controller/equipo_estadisticas.php?equipo='.$equipo->team->id.'">
                    <div class="logo_competicion"><img src="'.$equipo->team->logo.'" alt="Logo"></div>';
                $todosLosEquipos .= '<span>'.$equipo->team->name.'</span></a>';
                $todosLosEquipos .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="equipo_'.$equipo->team->id.'"></i>' : ''; 
                $todosLosEquipos .= '</div><hr>';
            }
        
            return $todosLosEquipos;
        }

        /* FUNCIONES COMPETICIONES JORNADAS */
        public function generarJornadas($jornadas) {
    
            $jornadasCompeticion = [];
            $fecha_actual = date('Y-m-d\TH:i:sP');

            foreach ($jornadas->response as $partido) {
        
                $hora_partido = strtotime($partido->fixture->date);
                $fechaPartido = date('Y-m-d\TH:i:sP', $hora_partido);
                $hora_partido = date('H:i', $hora_partido);

                $ronda = $partido->league->round;
        
                $partidosTotales = '
                    <div class="enfrentamiento_equipos">
                        <a href="../controller/partido_resumen.php?partido='.$partido->fixture->id.'">
                            <div class="equipo_local">
                                <img src="'.$partido->teams->home->logo.'" alt="Logo">
                                <span>'.$partido->teams->home->name.'</span>
                            </div>
                            <div class="resultado_hora">
                                <p>VS</p>';
                                if ($fecha_actual < $fechaPartido) {
                                    $partidosTotales .= '<p>'.$hora_partido.'</p>';
                                } else {

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

                isset($jornadasCompeticion[$ronda]) ? $jornadasCompeticion[$ronda] .= $partidosTotales : $jornadasCompeticion[$ronda] = $partidosTotales;

            }

            $contadorJornada = 1;
            $opcionesPartidos = "";
            $jornadasPartidos = "";

            foreach ($jornadasCompeticion as $nombreRonda => $datosJornada) {

                $contadorJornada++;
                $opcionesPartidos .= "<option value='jornada_$contadorJornada'>$nombreRonda</option>";
                $jornadasPartidos .= "<div class='ocultarjornada' id='jornada_$contadorJornada'>$datosJornada</div>";
        
            }

            return [$opcionesPartidos, $jornadasPartidos];
        }

        /* FUNCIONES FAVORITOS */
        public static function recogerCompeticionFavorita() {
        
            $arrayFavoritos = [];
    
            if (isset($_SESSION['usuario'])) {
                
                $usuario = unserialize($_SESSION['usuario']);
                $idUsuario = $usuario->__get("id");
        
                $conexion = FrancisGolBD::establecerConexion();
        
                $consulta = "SELECT * FROM competicion_favorita WHERE idUsuario = $idUsuario";
                $resultado = $conexion->query($consulta);
        
                while ($row = $resultado->fetch_assoc()) {
    
                    $arrayFavoritos[] = $row["idCompeticion"];
                }
                
                return $arrayFavoritos;
            }
        }

        public static function insertarCompeticionFavorita($idCompeticion, $idUsuario) {

            $conexion = FrancisGolBD::establecerConexion();
    
            $consulta = $conexion->prepare("INSERT INTO competicion_favorita (idUsuario, idCompeticion)  VALUES (?, ?)");
            $consulta->bind_param("ii", $idUsuario, $idCompeticion);
            $consulta->execute();
        }

        public static function eliminarCompeticionFavorita($idCompeticion, $idUsuario) {

            $conexion = FrancisGolBD::establecerConexion();
    
            $consulta = "SELECT * FROM competicion_favorita WHERE idUsuario = $idUsuario";
            $resultado = $conexion->query($consulta);
            if (mysqli_num_rows($resultado) == 1) return false;
    
            $consulta = $conexion->prepare("DELETE FROM competicion_favorita WHERE idUsuario = ? AND idCompeticion = ?");
            $consulta->bind_param("ii", $idUsuario, $idCompeticion);
            return $consulta->execute();
        }
    }