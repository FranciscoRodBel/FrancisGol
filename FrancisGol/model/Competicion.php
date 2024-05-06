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
        
            $conexion = FrancisGolBD::establecerConexion();
            $consulta = "SELECT * FROM competicion WHERE idCompeticion = $idCompeticion";
            $resultado = $conexion->query($consulta);
    
            if (mysqli_num_rows($resultado) == 1) {
        
                while($row = mysqli_fetch_assoc($resultado)) {
                    
                    $competicion = new Competicion($row['idCompeticion'], $row['nombre'], $row['logo']);
                }

            } else {

                $competicion = realizarConsulta("competicion_$idCompeticion", "leagues?id=$idCompeticion", 86400); 
                $competicion = $competicion->response[0]->league;
                $competicion = new Competicion($competicion->id, $competicion->name, $competicion->logo);
                $competicion->insertarCompeticion();
            }

            return $competicion;
        }

        public function pintarCompeticion($datosCompeticion) {

            $competicionesFavoritas = Competicion::recogerCompeticionFavorita();
            $claseFavorito = isset($_SESSION["usuario"]) && in_array($this->__get("id"), $competicionesFavoritas) ? "favorito" : "";

            $datosCompeticion = '<div class="competicion_equipo">
                <a>
                    <img src="'.$this->__get("logo").'" alt="Logo">
                    <span>'.$this->__get("nombre").'</span>
                </a>';
            $datosCompeticion .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="competicion_'.$this->__get("id").'"></i>' : '';   
            $datosCompeticion .= '</div><hr>';

            return $datosCompeticion;
        }

        public static function pintarCompeticiones($competiciones) {

            $competicionesFavoritas = !isset($_SESSION["usuario"]) ? [140, 39, 61, 78, 71, 2] : Competicion::recogerCompeticionFavorita();
            $datosCompeticion = "";
            
            foreach ($competiciones->response as $competicion) {

                if (in_array($competicion->league->id, $competicionesFavoritas)) {
                    $datosCompeticion .= '<div class="competicion_equipo competiciones">
                                        <a href="../controller/competicion_clasificacion.php?competicion='.$competicion->league->id.'">
                                            <img src="'.$competicion->league->logo.'" alt="Logo">
                                            <span>'.$competicion->league->name.'</span>
                                        </a>';
                    $datosCompeticion .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella favorito" id="competicion_'.$competicion->league->id.'"></i>' : '';   
                    $datosCompeticion .= '</div><hr>';
                }   

            }
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

            foreach ($equipoCompeticiones->response as $competicion) {

                $competicionesEquipo = new Competicion($competicion->league->id, $competicion->league->name, $competicion->league->logo);


                foreach ($competicion->seasons as $anio) {

                    $competicionesEquipo->anios[] = $anio->year;
                }
                $competiciones[] = $competicionesEquipo;

            }

            return $competiciones;
        }
        
        /* FUNCIONES COMPETICIÓN CLASIFICACIÓN */
        public function generarClasificacion($clasificacion) {
    
            // echo "<h3>Clasificación ".$clasificacion->response[0]->league->name." año ".$clasificacion->response[0]->league->season.": </h3>";
            $tablaClasificacion = "<table><thead><tr>
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
        
            foreach ($clasificacion->response[0]->league->standings[0] as $equipo) {
        
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
        
            return $tablaClasificacion;
        }

        /* FUNCIONES COMPETICION EQUIPOS */
        public function generarEquiposCompeticion($equipos) {

            $equiposFavoritos = Equipo::recogerEquiposFavorito();

            $todosLosEquipos = "";
        
            foreach ($equipos->response as $equipo) {
        
                $claseFavorito = isset($_SESSION['usuario']) && in_array($equipo->team->id, $equiposFavoritos) ? "favorito" : "";

                $todosLosEquipos .= "<a href='../controller/equipo_estadisticas.php?equipo={$equipo->team->id}'><div>";
                    $todosLosEquipos .= "<img src=".$equipo->team->logo." alt='logo competición'>";
                    $todosLosEquipos .= "<p>".$equipo->team->name."</p>";
                    $todosLosEquipos .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="equipo_'.$equipo->team->id.'"></i>' : ''; 
                $todosLosEquipos .= "</div></a>";
            }
        
            return $todosLosEquipos;
        }

        /* FUNCIONES COMPETICIONES JORNADAS */
        public function generarJornadas($jornadas) {
    
            $jornada = $jornadas->response[0]->league->round;
            $contadorJornada = 1;
            $partidosTotales = "<div class='ocultarjornada' id='jornada_$contadorJornada'>";
            $opcionesPartidos = "<option value='jornada_$contadorJornada'>Jornada $contadorJornada</option>";
        
            foreach ($jornadas->response as $key => $partido) {
        
                if ($jornada != $partido->league->round) {
        
                    $contadorJornada++;
                    $opcionesPartidos .= "<option value='jornada_$contadorJornada'>Jornada $contadorJornada</option>";
                    $jornada = $partido->league->round;
                    $partidosTotales .= "</div><div class='ocultarjornada' id='jornada_$contadorJornada'>";
        
                } else {
        
                    $partidosTotales .= '
                    <div class="enfrentamiento_equipos">
                        <a href="../controller/partido_resumen.php?partido='.$partido->fixture->id.'">
                            <div class="equipo_local">
                                <img src="'.$partido->teams->home->logo.'" alt="Logo">
                                <span>'.$partido->teams->home->name.'</span>
                            </div>
                            <div class="resultado_hora">
                                <p>VS</p>';
                                $partidosTotales .= '<p>'.$partido->goals->home.' - '.$partido->goals->away.'</p>';
        
                $partidosTotales .= '</div>
                            <div class="equipo_visitante">
                                <img src="'.$partido->teams->away->logo.'" alt="Logo">
                                <span>'.$partido->teams->away->name.'</span>
                            </div>
                        </a>
                    </div>
                    <hr class="separacion_partidos">';
                }
        
            }
        
            return [$opcionesPartidos, $partidosTotales];
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