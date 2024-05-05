<?php
    class Plantilla {
        public function __construct(
            protected int $id,
            protected string $titulo,
            protected int $anio,
            protected string $formacion,
            protected int $idUsuario,
            protected int $idEquipo
        ) {}

        public function __get(string $propiedad) {
            return $this->$propiedad;
        }

        public function __set(string $propiedad, $valor) {
            $this->$propiedad = $valor;
        }

        public static function recogerPlantilla($idPlantilla) {
    
            $conexion = FrancisGolBD::establecerConexion();
        
            $consulta = "SELECT * FROM plantilla WHERE idPlantilla = $idPlantilla";
        
            $resultado = $conexion->query($consulta);
        
            if (mysqli_num_rows($resultado) > 0) {
        
                while($row = mysqli_fetch_assoc($resultado)) {
                    
                    $plantillaUsuario = new Plantilla($row['idPlantilla'], $row['titulo'], $row['anio'], $row['formacion'], $row['idUsuario'], $row['idEquipo']);
                }

            } else {
                header("Location: ../controller/plantillas_mis.php");
                die();
            }
        
            return $plantillaUsuario;
        }

        public static function recogerPlantillasUsuario($idUsuario, $condicion) {
    
            $conexion = FrancisGolBD::establecerConexion();
        
            if ($condicion) {

                $consulta = "SELECT * FROM plantilla WHERE idUsuario = $idUsuario";
                
            } else {
                
                $consulta = "SELECT * FROM plantilla WHERE idUsuario != $idUsuario";
            }

        
            $resultado = $conexion->query($consulta);
        
            if (mysqli_num_rows($resultado) > 0) {
        
                while($row = mysqli_fetch_assoc($resultado)) {
                    
                    $plantillasUsuario[] = new Plantilla($row['idPlantilla'], $row['titulo'], $row['anio'], $row['formacion'], $row['idUsuario'], $row['idEquipo']);
                }

            } else {
                $plantillasUsuario = [];
            }
        
            return $plantillasUsuario;
        }

        public function pintarPlantilla($accion) {

            $equipo = Equipo::recogerEquipo($this->__get('idEquipo'));

            $ruta = $accion == "editar" ? "plantillas_editar.php" : "plantillas_ver.php" ;

            $plantilla = "<div class='mi_plantilla'>
                            <a href='../controller/$ruta?plantilla={$this->__get('id')}'>
                                <div>
                                    <img src='{$equipo->__get('escudo')}' alt='escudo'>
                                    <p>{$this->__get('titulo')}</p>
                                </div>
                                <div>
                                    <p>{$this->__get('formacion')}</p>
                                    <p>{$this->__get('anio')}</p>
                                </div>
                            </a>
                        </div>";
        
            return $plantilla;
        }

        /* FUNCIONES DE GUARDAR PLANTILLAS */
        public static function comprobarDatosJugadores($formacion, $posicionesJugadores, $datosPlantilla) {
            $posiciones = Plantilla::generarClasesPosicionJugador($formacion);
        
            foreach (json_decode($datosPlantilla)->response[0]->players as $numeroJugador => $jugador) {
        
                if($numeroJugador >= 11 && $numeroJugador < 23) {
                    
                    array_push($posiciones, "suplentes_$numeroJugador");
        
                } else if($numeroJugador >= 23) {
        
                    array_push($posiciones, "no_convocado_$numeroJugador");
                }
        
                if (!array_key_exists($jugador->id, $posicionesJugadores)) {
                    return false;
                }
            }
        
            foreach ($posicionesJugadores as $posicionesJugador) {
                
                if (!in_array($posicionesJugador, $posiciones)) {
                    return false;
                    
                } else {
                    unset($posiciones[array_search($posicionesJugador,$posiciones)]);
                }
        
            }
        
            return true;
        }
        
        public static function guardarDatosJugadores($posicionesJugadores, $titulo, $formacion, $datosPlantilla) {
            
            $conexion = FrancisGolBD::establecerConexion();
        
            $usuario = unserialize($_SESSION['usuario']);
            $idUsuario = $usuario->__get("id");
            $anio = 2023;
            $equipo = json_decode($datosPlantilla)->response[0]->team;
            $idEquipo = $equipo->id;
        
            $equipo = new Equipo($idEquipo, $equipo->name, $equipo->logo);
            $equipo->insertarEquipo();
        
            $consulta = $conexion->prepare("INSERT INTO plantilla (titulo, anio, formacion, idUsuario, idEquipo)  VALUES (?, ?, ?, ?, ?)");
            $consulta->bind_param("sisii", $titulo, $anio, $formacion, $idUsuario, $idEquipo);
            $consulta->execute();
            
            $idPlantilla = mysqli_insert_id($conexion);
        
            foreach (json_decode($datosPlantilla)->response[0]->players as $jugador) {
                
                $idJugador = $jugador->id;
                $posicion = $posicionesJugadores[$idJugador];
            
                $jugador = new Jugador($idJugador, $jugador->name, $jugador->photo);
                $jugador->insertarJugador();
        
                $consulta = $conexion->prepare("INSERT INTO plantilla_jugador (idPlantilla,	idJugador,	posicion)  VALUES (?, ?, ?)");
                $consulta->bind_param("iis", $idPlantilla, $idJugador, $posicion);
                $consulta->execute();
        
            }
        
            return $idPlantilla;
        }

        /* FUNCIONES DE CREAR PLANTILLAS */

        public static function generarSelectFormaciones($formacionSeleccionada = "4-3-3") {
            $formaciones = array("3-1-4-2", "3-4-1-2", "3-4-2-1", "3-4-3", "3-5-1-1", "3-5-2", "3-6-1", "4-1-2-1-2", "4-1-3-1-1", "4-1-3-2", "4-1-4-1", "4-2-1-3", "4-2-2-2", "4-2-3-1", "4-3-1-2", "4-3-2-1", "4-3-3", "4-4-1-1", "4-4-2", "4-5-1", "5-3-2", "5-4-1");
            
            $optionsFormaciones = "";
            foreach ($formaciones as $formacion) {
        
                if ($formacion == $formacionSeleccionada) {
        
                    $optionsFormaciones .= "<option value='$formacion' selected>$formacion</option>";
                } else {
        
                    $optionsFormaciones .= "<option value='$formacion'>$formacion</option>";
                }
        
            }
            return $optionsFormaciones;
        }
        
        public static function generarPlantilla($equipoPlantilla) {
        
            $clasesJugador = Plantilla::generarClasesPosicionJugador("4-3-3");
        
            $alineacionPrincipal = "<div class='alineacion'><div class='formacion_equipo formacion_4-3-3'>"; 
            
            
            foreach ($equipoPlantilla->response[0]->players as $numeroJugador => $jugador) {
        
                if ($numeroJugador < 11) {
                    
                    $alineacionPrincipal .= 
                    "<div class='".$clasesJugador[$numeroJugador]."' draggable='true' data-idJugador='{$jugador->id}'>
                        <img src='{$jugador->photo}' alt='foto'>
                        <p>{$jugador->name}</p>
                    </div>";
        
                } else if($numeroJugador < 23) {
        
                    $alineacionPrincipal .= $numeroJugador == 11 ? "</div></div><p class='titulo_seccion'>Suplentes</p><section class='seccion_negra jugadores_suplentes'>" : "";
                    
                    $alineacionPrincipal .= "<div class='suplentes_".$numeroJugador."' draggable='true' data-idJugador='{$jugador->id}'>
                                                <img src='{$jugador->photo}' alt='foto'>
                                                <p>{$jugador->name}</p>
                                            </div>";
                } else {
        
                    $alineacionPrincipal .= $numeroJugador == 23 ? "</section><p class='titulo_seccion'>No convocados</p><section class='seccion_negra jugadores_suplentes'>" : "";
                    
                    $alineacionPrincipal .= "<div class='no_convocado_".$numeroJugador."' draggable='true' data-idJugador='{$jugador->id}'>
                                                <img src='{$jugador->photo}' alt='foto'>
                                                <p>{$jugador->name}</p>
                                            </div>";
                }
                
            }
            $alineacionPrincipal .= "</section>";
            return $alineacionPrincipal;
        }
        
        public static function generarClasesPosicionJugador($formacion) {
            
            $formacion = explode("-",$formacion);
        
            $clasesGeneradas = ["jugador_1_1"];
        
            foreach ($formacion as $clave => $numeroJugadoresPosicion) {
                
                for ($i=1; $i <= $numeroJugadoresPosicion; $i++) { 
                    
                    array_push($clasesGeneradas, "jugador_". $clave+2 ."_".$i);
                }
            }
        
            return $clasesGeneradas;
        }

        /* FUNCIONES PÁGINA DE EDITAR PLANTILLA */

        public function recogerDatosPlantilla() {

            $datosPlantilla = [];
            $idPlantilla = $this->__get("id");
            $conexion = FrancisGolBD::establecerConexion();

            $consulta = "SELECT * 
                        FROM jugador ju
                        INNER JOIN plantilla_jugador pj
                        ON pj.idJugador = ju.idJugador
                        WHERE pj.idPlantilla = $idPlantilla";

            $resultado = $conexion->query($consulta);



            if (mysqli_num_rows($resultado) > 0) {
        
                while($row = mysqli_fetch_assoc($resultado)) {
                    
                    $datosPlantilla[$row['posicion']] = ["id" => $row['idJugador'], "nombre" => $row['nombre'], "foto" => $row['foto']];
                }

            }

            return $datosPlantilla;
        }

        public function pintarPlantillaEditar($datosPlantilla) {
            
            $formacion = $this->__get("formacion");

            $alineacion = "<div class='alineacion'><div class='formacion_equipo formacion_$formacion'>"; 
            
            $formaciones = Plantilla::generarClasesPosicionJugador($formacion);
            
            foreach ($formaciones  as $formacion) {

                $datosJugador = $datosPlantilla[$formacion];

                $alineacion .= "<div class='".$formacion."' draggable='true' data-idJugador='".$datosJugador["id"]."'>
                    <img src='".$datosJugador["foto"]."' alt='foto'>
                    <p>".$datosJugador["nombre"]."</p>
                </div>";
            }

            $alineacion .= "</div></div><p class='titulo_seccion'>Suplentes</p><section class='seccion_negra jugadores_suplentes'>";

            for ($i = 11; $i < 23; $i++) { 
                
                $datosJugador = $datosPlantilla["suplentes_$i"];

                $alineacion .= "<div class='suplentes_".$i."' draggable='true' data-idJugador='".$datosJugador["id"]."'>
                                    <img src='".$datosJugador["foto"]."' alt='foto'>
                                    <p>".$datosJugador["nombre"]."</p>
                                </div>";
            }

            $alineacion .= "</section><p class='titulo_seccion'>No convocados</p><section class='seccion_negra jugadores_suplentes'>";


            for ($i = 23; $i < count($datosPlantilla); $i++) { 
                
                $datosJugador = $datosPlantilla["no_convocado_$i"];

                $alineacion .= "<div class='no_convocado_".$i."' draggable='true' data-idJugador='".$datosJugador["id"]."'>
                                    <img src='".$datosJugador["foto"]."' alt='foto'>
                                    <p>".$datosJugador["nombre"]."</p>
                                </div>";
            }

            $alineacion .= "</section>";

            return $alineacion;
        }

        public function actualizarDatosJugadores($posicionesJugadores, $titulo, $formacion) {

            $idPlantilla = $this->__get("id");
            $conexion = FrancisGolBD::establecerConexion();

            try {

                $consulta = $conexion->prepare("UPDATE plantilla SET titulo = ?, formacion = ? WHERE idPlantilla = ?");
                $consulta->bind_param("ssi", $titulo, $formacion, $idPlantilla);
                $consulta->execute();
    
                foreach ($posicionesJugadores as $idJugador => $posicion) {
    
                    $consulta = $conexion->prepare("UPDATE plantilla_jugador SET posicion = ? WHERE idPlantilla = ? AND idJugador = ?");
                    $consulta->bind_param("sii", $posicion, $idPlantilla, $idJugador);
                    $consulta->execute();
                    
                }
    
            } catch (mysqli_sql_exception) {

                return "No se pudieron actualizar los datos";
            }

            return "Plantilla editada correctamente";
        }

        /* FUNCIONES BORRAR PLANTILLA */

        public function borrarPlantilla() {
            
            $idPlantilla = $this->__get("id");
            $conexion = FrancisGolBD::establecerConexion();

            $consulta = $conexion->prepare("DELETE FROM plantilla WHERE idPlantilla = ?");
            $consulta->bind_param("i", $idPlantilla);
            $consulta->execute();

        }
    }