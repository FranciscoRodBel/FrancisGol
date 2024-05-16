<?php
    class Equipo {
        
        public function __construct(
            protected int $id,
            protected string $nombre,
            protected string $escudo
        ) {}

        public function __get(string $propiedad) {
            return $this->$propiedad;
        }

        public function __set(string $propiedad, $valor) {
            $this->$propiedad = $valor;
        }

        public static function recogerEquipo($idEquipo) {
        
            if (is_numeric($idEquipo)) {

                $conexion = FrancisGolBD::establecerConexion();
                $consulta = "SELECT * FROM equipo WHERE idEquipo = $idEquipo";
                $resultado = $conexion->query($consulta);
        
                if (mysqli_num_rows($resultado) == 1) {
            
                    while($row = mysqli_fetch_assoc($resultado)) {
                        
                        $equipo = new Equipo($row['idEquipo'], $row['nombre'], $row['escudo']);
                    }
    
                } else {
    
                    $equipo = realizarConsultaSinJson("teams?id=$idEquipo");
    
                    if (!empty($equipo)) {

                        $equipo = $equipo->response[0]->team;
                        $equipo = new Equipo($equipo->id, $equipo->name, $equipo->logo);
                        $equipo->insertarEquipo();

                    } else {

                        return "";
                    }
                }
    
                return $equipo;
            }

            return "";
        }

        public function pintarEquipo() {
            
            $equiposFavoritos = Equipo::recogerEquiposFavorito();
            $claseFavorito = isset($_SESSION["usuario"]) && in_array($this->__get("id"), $equiposFavoritos) ? "favorito" : "";
            
            $datosEquipo = '<div class="competicion_equipo competiciones">
                <a href="../controller/equipo_estadisticas.php?equipo='.$this->__get("id").'">
                    <div class="logo_competicion"><img src="'.$this->__get("escudo").'" alt="Logo"></div>
                    <span>'.$this->__get("nombre").'</span>
                </a>';
            $datosEquipo .= isset($_SESSION["usuario"]) ? '<i class="fa-solid fa-star icono_estrella '.$claseFavorito.'" id="equipo_'.$this->__get("id").'"></i>' : ''; 
            $datosEquipo .= '</div><hr>';

            return $datosEquipo;
        }


        /* FUNCIONES EQUIPOS ESTADÍSTICAS */
        
        public function generarOpcionesCompeticiones($equipoCompeticiones) {
            
            $opcionesCompeticiones = "";

            foreach ($equipoCompeticiones as $competicion) {
                
                $opcionesCompeticiones .= "<option value='{$competicion->id}'>{$competicion->nombre}</option>";
            }

            return $opcionesCompeticiones;
        }


        public function generarOpcionesAnios($equipoCompeticiones) {


            foreach ($equipoCompeticiones as $competicion) {

                $opcionesAnios = "";

                foreach ($competicion->anios as $key => $anio) {
                    
                    if (count($competicion->anios) == $key+1) {
                        

                        $opcionesAnios .= "<option value='{$anio}' selected>{$anio}</option>";
                    } else {

                        $opcionesAnios .= "<option value='{$anio}'>{$anio}</option>";
                    }
                }

                $arrayOpcionesAnios[$competicion->id] = $opcionesAnios;
            }

            return $arrayOpcionesAnios;
        }

        public function pintarEstadisticasEquipo($equipoEstadisticas) {

            $tablaEstadisticas = $this->pintarTablaEstadisticas($equipoEstadisticas);
            $tablaEstadisticas .= $this->pintarTablaGoles($equipoEstadisticas);
            $tablaEstadisticas .= $this->pintarTablaRachas($equipoEstadisticas);

            return $tablaEstadisticas;
        }

        public function pintarTablaEstadisticas($equipoEstadisticas) {

            $tipoEstadisticaFixtures = array(
                "Partidos",
                "Victorias",
                "Empates",
                "Derrotas",
            );

            $tablaEstadisticas = "<table class='tabla_datos estadisticas_equipo'>";
            $tablaEstadisticas .= "<thead><tr><th rowspan='2'></th><th colspan='3'>Estadísticas</th></tr>";
            $tablaEstadisticas .= "<tr><td>Totales</td><td>Local</td><td>Visitante</td></tr></thead>";
            $tablaEstadisticas .= "<tbody>";

            $contador = 0;
            foreach ($equipoEstadisticas->response->fixtures as $key => $estadistica) {
                $tablaEstadisticas .= "
                    <tr>
                        <td class='tipo_estadistica'>".$tipoEstadisticaFixtures[$contador++]."</td>
                        <td>". $estadistica->total ."</td>
                        <td>". $estadistica->home ."</td>
                        <td>". $estadistica->away ."</td>
                    </tr>";
            }

            return $tablaEstadisticas;
        }

        public function pintarTablaGoles($equipoEstadisticas) {

            $tablaEstadisticas = "";
            $tipoEstadisticaGoles = array(
                "Goles",
                "Promedio G/P",
            );

            $contador = 0;
            foreach ($equipoEstadisticas->response->goals->for as $tipoEstadistica => $estadistica) {

                if ($tipoEstadistica == "minute") {

                    $tablaEstadisticas .= "</tbody></table>";
                    $tablaEstadisticas .= "<table class='tabla_datos estadisticas_equipo_goles'>";
                    $tablaEstadisticas .= "<thead><tr><th colspan='3'>Goles por minutos</th></tr>";
                    $tablaEstadisticas .= "<tr><td>Minuto</td><td>Goles</td><td>Porcentaje</td></tr></thead>";
                    $tablaEstadisticas .= "<tbody>";

                    foreach ($estadistica as $minutos => $datosMinutos) {

                        $tablaEstadisticas .= "
                        <tr>
                            <td>". $minutos ."</td>
                            <td>". $datosMinutos->total ."</td>
                            <td>". $datosMinutos->percentage ."</td>
                        </tr>";
                    }

                } else {

                    $tablaEstadisticas .= "
                    <tr>
                        <td>".$tipoEstadisticaGoles[$contador++]."</td>
                        <td>". $estadistica->total ."</td>
                        <td>". $estadistica->home ."</td>
                        <td>". $estadistica->away ."</td>
                    </tr>";
                }
            }

            $tablaEstadisticas .= "</tbody></table>";
            return $tablaEstadisticas;
        }

        public function pintarTablaRachas($equipoEstadisticas) {
            
            $tipoEstadisticaRachas = array(
                "Victorias",
                "Empates",
                "Derrotas",
                "Mejor Victoria local",
                "Mejor Victoria visitante",
                "Peor Derrota local",
                "Peor Derrota visitante",
                "Máximo de goles marcados de local",
                "Máximo de goles marcados de Visitante",
                "Máximo de goles recibidos de local",
                "Máximo de goles recibidos de Visitante",
                "Porterías a 0 de local",
                "Porterías a 0 de visitante",
                "Porterías a 0 de total",
                "Sin marcar de local",
                "Sin marcar de visitante",
                "Sin marcar de total",
            );

            $tablaEstadisticas = "<table class='tabla_datos estadisticas_equipo_datos'>";
            $tablaEstadisticas .= "<thead><tr><th colspan='3'>Datos</th></tr>";
            $tablaEstadisticas .= "<tbody>";

            $contador = 0;
            foreach ($equipoEstadisticas->response->biggest as $estadisticas) {

                foreach ($estadisticas as $tipoEstadistica2 => $estadistica) {

                    if ($tipoEstadistica2 == "for" || $tipoEstadistica2 == "against") {
                    
                        foreach ($estadistica as $datoEstadistica) {

                            $tablaEstadisticas .= "
                            <tr>
                                <td>".$tipoEstadisticaRachas[$contador++]."</td>
                                <td>". $datoEstadistica ."</td>
                            </tr>";
                
                        }

                    } else {
                        $tablaEstadisticas .= "
                        <tr>
                            <td>".$tipoEstadisticaRachas[$contador++]."</td>
                            <td>". $estadistica ."</td>
                        </tr>";
            
                    }
                }
            }

            foreach ($equipoEstadisticas->response->clean_sheet as $estadistica) {

                $tablaEstadisticas .= "
                <tr>
                    <td>".$tipoEstadisticaRachas[$contador++]."</td>
                    <td>". $estadistica ."</td>
                </tr>";
            }

            foreach ($equipoEstadisticas->response->failed_to_score as $estadistica) {

                $tablaEstadisticas .= "
                <tr>
                    <td>".$tipoEstadisticaRachas[$contador++]."</td>
                    <td>". $estadistica ."</td>
                </tr>";
            }

            $tablaEstadisticas .= "</tbody></table>";
            return $tablaEstadisticas;
        }

        /* FUNCIONES EQUIPO PLANTILLA */
        public function generarPlantilla($equipoPlantilla) {

            $jugadoresPlantilla = "<div><div>Foto</div>";
            $jugadoresPlantilla .= "<div>Nombre</div>";
            $jugadoresPlantilla .= "<div>Edad</div>";
            $jugadoresPlantilla .= "<div>Dorsal</div>";
            $jugadoresPlantilla .= "<div>Posicion</div>";
            $jugadoresPlantilla .= "</div>";
        
            foreach ($equipoPlantilla->response[0]->players as $key => $jugador) {
        
                $posicion = match ($jugador->position) {
                   "Goalkeeper" => "Portero",
                   "Defender" => "Defensa",
                   "Midfielder" => "Mediocentro",
                   "Attacker" => "Delantero",
                   default => "Desconocida"
                };
        
                $jugadoresPlantilla .= "<a href='../controller/jugador_datos.php?jugador=".$jugador->id."'><div>";
                $jugadoresPlantilla .= "<img src=".$jugador->photo." alt='logo competición'>";
                $jugadoresPlantilla .= "<div>".$jugador->name."</div>";
                $jugadoresPlantilla .= "<div>".$jugador->age."</div>";
                $jugadoresPlantilla .= "<div>".$jugador->number."</div>";
                $jugadoresPlantilla .= "<div>".$posicion."</div>";
                $jugadoresPlantilla .= "</div></a>";
            }
            $jugadoresPlantilla .= "</tbody></table>";
            return $jugadoresPlantilla;
        }

        /* Acciones equipo BBDD */

        public function insertarEquipo() {
            $conexion = FrancisGolBD::establecerConexion();
            
            $idEquipo = $this->__get('id');
            $nombreEquipo = $this->__get('nombre');
            $escudoEquipo = $this->__get('escudo');

            $consulta = $conexion->prepare("INSERT INTO equipo (idEquipo, nombre, escudo)  VALUES (?, ?, ?)");
    
            try {
                $consulta->bind_param("iss", $idEquipo, $nombreEquipo, $escudoEquipo);
                $consulta->execute();
    
            } catch (mysqli_sql_exception) {
                // Si el equipo ya está insertado no hace nada
            }
        }

        /* FUNCIONES DE EQUIPOS FAVORITOS */

        public static function recogerEquiposFavorito() {
    
            $arrayFavoritos = [];
    
            if (isset($_SESSION['usuario'])) {
    
                $usuario = unserialize($_SESSION['usuario']);
                $idUsuario = $usuario->__get("id");
        
                $conexion = FrancisGolBD::establecerConexion();
        
                $consulta = "SELECT ef.idEquipo, eq.nombre FROM equipo_favorito ef
                             INNER JOIN equipo eq
                             ON eq.idEquipo = ef.idEquipo
                             WHERE ef.idUsuario = $idUsuario";
                $resultado = $conexion->query($consulta);
        
                while ($row = $resultado->fetch_assoc()) {
    
                    $arrayFavoritos[$row["nombre"]] = $row["idEquipo"];
                }
                
                return $arrayFavoritos;
            }
        }
        public static function insertarEquipoFavorito($idEquipo, $idUsuario) {

            $conexion = FrancisGolBD::establecerConexion();
    
            $consulta = $conexion->prepare("INSERT INTO equipo_favorito (idUsuario, idEquipo)  VALUES (?, ?)");
            $consulta->bind_param("ii", $idUsuario, $idEquipo);
            $consulta->execute();
        }
    
        public static function eliminarEquipoFavorito($idEquipo, $idUsuario) {
    
            $conexion = FrancisGolBD::establecerConexion();
    
            $consulta = "SELECT * FROM equipo_favorito WHERE idUsuario = $idUsuario";
            $resultado = $conexion->query($consulta);
            if (mysqli_num_rows($resultado) == 1) return false;
    
            $consulta = $conexion->prepare("DELETE FROM equipo_favorito WHERE idUsuario = ? AND idEquipo = ?");
            $consulta->bind_param("ii", $idUsuario, $idEquipo);
            return $consulta->execute();
            
        }

        public static function pintarEquiposFavoritos() {
            
            $resultadoEquipos = "";
            $equiposFavoritos = isset($_SESSION["usuario"]) ?  Equipo::recogerEquiposFavorito() : [530, 529, 541, 157, 50, 85];
        
            foreach ($equiposFavoritos as $idEquipo) {
        
                $equipo = Equipo::recogerEquipo($idEquipo);
                $resultadoEquipos .= $equipo->pintarEquipo();
            }

            return $resultadoEquipos;
        }

        /* FUNCIONES PÁGINA DE FICHAJES DE EQUIPO*/
        public static function pintarFichajesEquipo($fichajesEquipo) {

            $fichajes = "";
            $anioActual = date("Y") - 1;
            $anioSiguiente = date("Y");

            foreach ($fichajesEquipo->response as $key => $jugador) {
        
                foreach ($jugador->transfers as $key => $datoFichaje) {
        
                    if (preg_match("/^$anioSiguiente/", $datoFichaje->date) || preg_match("/^$anioActual/", $datoFichaje->date)) {
            
                        // $jugador->player->id
                        $fichajes .= "<div>
                            <div class='datos_fichaje'>
                                <img src='https://media.api-sports.io/football/players/".$jugador->player->id.".png' alt='foto' class='foto_jugador'>
                                <a href='../controller/jugador_datos.php?jugador=".$jugador->player->id."'>".$jugador->player->name."</a>
                                <hr>
                                <p>".$datoFichaje->date."</p>
                            </div>
                            <div class='fichaje_equipos'>
                                <div class='equipo_fichaje'>
                                    <a href='../controller/equipo_estadisticas.php?equipo={$datoFichaje->teams->out->id}'>
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
                                    <a href='../controller/equipo_estadisticas.php?equipo={$datoFichaje->teams->in->id}'>
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

        public static function generarSelectEquipos($equipos) {
            
            $opcionesEquipos = "<select class='seleccionar' id='seleccion_equipo'>";

            foreach ($equipos as $nombreEquipo => $idEquipo) {
                
                $opcionesEquipos .= "<option value='{$idEquipo}'>{$nombreEquipo}</option>";
            }
            $opcionesEquipos .= "/<select>";

            return $opcionesEquipos;
        }
    }