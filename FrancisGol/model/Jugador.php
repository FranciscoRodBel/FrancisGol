<?php
    class Jugador {
        
        public function __construct(
            protected int $id,
            protected string $nombre,
            protected string $foto
        ) {}

        public function __get(string $propiedad) {
            return $this->$propiedad;
        }

        public function __set(string $propiedad, $valor) {
            $this->$propiedad = $valor;
        }

        public static function recogerJugador($idJugador) {

                $conexion = FrancisGolBD::establecerConexion();
                $consulta = "SELECT * FROM jugador WHERE idJugador = $idJugador";
                $resultado = $conexion->query($consulta);
        
                if (mysqli_num_rows($resultado) == 1) {
            
                    while($row = mysqli_fetch_assoc($resultado)) {
                        
                        $jugador = new Jugador($row['idJugador'], $row['nombre'], $row['foto']);
                    }
    
                } else {

                    $anioActual = date("Y") - 1;
                    $jugador = realizarConsulta("jugador_".$idJugador."_".$anioActual, "/players?id=$idJugador&season=$anioActual", 86400);
            
                    if (!empty($jugador)) {

                        $jugador = $jugador->response[0]->player;
                        $jugador = new Jugador($jugador->id, $jugador->name, $jugador->photo);
                        $jugador->insertarJugador();

                    } else {

                        return "";
                    }

                }

            return $jugador;
        }

        public function pintarJugador() {

            $datosJugador = '<div class="competicion_equipo">
                <a>
                    <div class="logo_competicion"><img src="'.$this->__get("foto").'" alt="Logo"></div>
                    <span>'.$this->__get("nombre").'</span>
                </a>
            </div><hr>';

            return $datosJugador;
        }

        /* FUNCIONES JUGADOR DATOS */
        public function pintarDatosJugador($anio) {

            $datosJugador = realizarConsulta("jugador_".$this->__get("id")."_".$anio, "/players?id=".$this->__get("id")."&season=$anio", 86400);
            
            if (!empty($datosJugador)) {

                $tablaDatosJugador = "";
                $selectCompeticion = "";
                $tablaEstadsticasJugador = "";

                foreach($datosJugador->response as $jugador) {
            
                    $tablaDatosJugador .= "
                        <table class='tabla_datos'>
                        <thead><tr><th colspan='2'>Datos</th></tr></thead><tbody>
                        <tr><td>Apodo</td><td>".$jugador->player->name."</td></tr>
                        <tr><td>Nombre</td><td>".$jugador->player->firstname."</td></tr>
                        <tr><td>Apellidos</td><td>".$jugador->player->lastname."</td></tr>
                        <tr><td>Edad</td><td>".$jugador->player->age."</td></tr>
                        <tr><td>Fecha nacimiento</td><td>".$jugador->player->birth->date."</td></tr>
                        <tr><td>Lugar de nacimiento</td><td>".$jugador->player->birth->place."</td></tr>
                        <tr><td>País de nacimiento</td><td>".$jugador->player->birth->country."</td></tr>
                        <tr><td>Nacionalidad</td><td>".$jugador->player->nationality."</td></tr>
                        <tr><td>Altura</td><td>".$jugador->player->height."</td></tr>
                        <tr><td>Peso</td><td>".$jugador->player->weight."</td></tr>
                        <tr><td>Lesionado</td><td>".$jugador->player->injured."</td></tr>
                        </tbody></table>";
            
                    foreach ($jugador->statistics as $key => $estadistica) {
            
                        $selectCompeticion .= "<option value='".$estadistica->league->name."'>".$estadistica->league->name."</option>";
                        $tablaEstadsticasJugador .= "
                        <table class='tabla_datos ".($key == 0 ? "" : "ocultar" )."'>
                        <thead><tr><th colspan='2'>Estadísticas</th></tr></thead><tbody>
                        <tr><td>Equipo</td><td>".$estadistica->team->name."</td></tr>
                        <tr><td>Competición</td><td class='competiciones'>".$estadistica->league->name."</td></tr>
                        <tr><td>País</td><td>".$estadistica->league->country."</td></tr>
                        <tr><td>Año</td><td>".$estadistica->league->season."</td></tr>
                        <tr><td>Partidos jugados</td><td>".$estadistica->games->appearences."</td></tr>
                        <tr><td>Veces alineado</td><td>".$estadistica->games->lineups."</td></tr>
                        <tr><td>Minutos jugados</td><td>".$estadistica->games->minutes."</td></tr>
                        <tr><td>Dorsal</td><td>".$estadistica->games->number."</td></tr>
                        <tr><td>Posición</td><td>".$estadistica->games->position."</td></tr>
                        <tr><td>Puntuación</td><td>".$estadistica->games->rating."</td></tr>
                        <tr><td>Capitán</td><td>".$estadistica->games->captain."</td></tr>
                        <tr><td>Entrar de cambio</td><td>".$estadistica->substitutes->in."</td></tr>
                        <tr><td>Salir de cambio</td><td>".$estadistica->substitutes->out."</td></tr>
                        <tr><td>Suplente</td><td>".$estadistica->substitutes->bench."</td></tr>
                        <tr><td>Total de tiros</td><td>".$estadistica->shots->total."</td></tr>
                        <tr><td>Tiros a puerta</td><td>".$estadistica->shots->on."</td></tr>
                        <tr><td>Goles</td><td>".$estadistica->goals->total."</td></tr>
                        <tr><td>Asistencias</td><td>".$estadistica->goals->assists."</td></tr>
                        <tr><td>Goles salvados</td><td>".$estadistica->goals->saves."</td></tr>
                        <tr><td>Goles concedidos</td><td>".$estadistica->goals->conceded."</td></tr>
                        <tr><td>Total de pases</td><td>".$estadistica->passes->total."</td></tr>
                        <tr><td>Pases clave</td><td>".$estadistica->passes->key."</td></tr>
                        <tr><td>Pases precisos</td><td>".$estadistica->passes->accuracy."</td></tr>
                        <tr><td>Encontronazos</td><td>".$estadistica->tackles->total."</td></tr>
                        <tr><td>Encontronazos bloqueados</td><td>".$estadistica->tackles->blocks."</td></tr>
                        <tr><td>Intercepciones</td><td>".$estadistica->tackles->interceptions."</td></tr>
                        <tr><td>Duelos</td><td>".$estadistica->duels->total."</td></tr>
                        <tr><td>Duelos ganados</td><td>".$estadistica->duels->won."</td></tr>
                        <tr><td>Regates realizados</td><td>".$estadistica->dribbles->attempts."</td></tr>
                        <tr><td>Regates realizados con exito</td><td>".$estadistica->dribbles->success."</td></tr>
                        <tr><td>Regates realizados sin exito</td><td>".$estadistica->dribbles->past."</td></tr>
                        <tr><td>Faltas recibidas</td><td>".$estadistica->fouls->drawn."</td></tr>
                        <tr><td>Faltas cometidas</td><td>".$estadistica->fouls->committed."</td></tr>
                        <tr><td>Tarjetas amarillas</td><td>".$estadistica->cards->yellow."</td></tr>
                        <tr><td>Tarjetas roja por amarillas</td><td>".$estadistica->cards->yellowred."</td></tr>
                        <tr><td>Tarjetas roja</td><td>".$estadistica->cards->red."</td></tr>
                        <tr><td>Penaltis ganados</td><td>".$estadistica->penalty->won."</td></tr>
                        <tr><td>Penaltis cometidos</td><td>".$estadistica->penalty->commited."</td></tr>
                        <tr><td>Penaltis marcados</td><td>".$estadistica->penalty->scored."</td></tr>
                        <tr><td>Penaltis fallados</td><td>".$estadistica->penalty->missed."</td></tr>
                        <tr><td>Penaltis parados</td><td>".$estadistica->penalty->saved."</td></tr>
                        </tbody></table>";
                    }

                    $tablaDatosJugador .= "
                        <div class='centraHorizontal'>
                            <select id='jugadorEstadisticas' class='seleccionar'>
                                $selectCompeticion
                            </select>
                        </div>";
                }

            } else {

                return "";
            }

            $tablaDatosJugador .= $tablaEstadsticasJugador;
            return $tablaDatosJugador;
        }
        
        /* FUNCIONES JUGADOR TROFEOS */
        public function pintarTrofeosJugador($trofeosJugador) {

            $tablaTrofeos ="<table class='tabla_datos tabla_trofeos'>
            <thead><tr><th colspan='3'>Trofeos</th></tr>
            <tr><td>Competición</td><td>Tipo</td><td>Temporada</td></tr></thead><tbody>";
        
            foreach ($trofeosJugador->response as $trofeo) {
        
                if ($trofeo->place == "Winner") {
                    $tablaTrofeos .= "<tr>
                        <td>". $trofeo->league ."</td>
                        <td>". $trofeo->country ."</td>
                        <td>". $trofeo->season ."</td>
                    </tr>";
                }
            }
        
            $tablaTrofeos .= "</tbody></table>";
        
            return $tablaTrofeos;
        }

        public function insertarJugador() {
            $conexion = FrancisGolBD::establecerConexion();
            
            $idJugador = $this->__get('id');
            $nombreJugador = $this->__get('nombre');
            $fotoJugador = $this->__get('foto');

            $consulta = $conexion->prepare("INSERT INTO jugador (idJugador, nombre, foto)  VALUES (?, ?, ?)");
    
            try {
                $consulta->bind_param("iss", $idJugador, $nombreJugador, $fotoJugador);
                $consulta->execute();
    
            } catch (mysqli_sql_exception) {
                // Si el jugador ya está insertado no hace nada
            }
        }
    }