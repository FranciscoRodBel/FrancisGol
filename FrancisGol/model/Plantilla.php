<?php
    class Plantilla {

        protected static array $formaciones = array("3-1-4-2", "3-4-1-2", "3-4-2-1", "3-4-3", "3-5-1-1", "3-5-2", "3-6-1", "4-1-2-1-2", "4-1-3-1-1", "4-1-3-2", "4-1-4-1", "4-2-1-3", "4-2-2-2", "4-2-3-1", "4-3-1-2", "4-3-2-1", "4-3-3", "4-4-1-1", "4-4-2", "4-5-1", "5-3-2", "5-4-1");

        public function __construct(
            protected int $id,
            protected string $titulo,
            protected int $anio,
            protected string $formacion,
            protected string $datosPlantilla,
            protected int $idUsuario,
            protected int $idEquipo
        ) {}

        public function __get(string $propiedad) {
            return $this->$propiedad;
        }

        public function __set(string $propiedad, $valor) {
            $this->$propiedad = $valor;
        }

        public static function recogerPlantilla(int|string $idPlantilla): object|string  {
    
            if (is_numeric($idPlantilla)) { // Compruebo si el id es un número
                
                $conexion = FrancisGolBD::establecerConexion();
        
                $consulta = "SELECT * FROM plantilla WHERE idPlantilla = $idPlantilla"; // Recojo los datos de la plantilla 
            
                $resultado = $conexion->query($consulta);
            
                if (mysqli_num_rows($resultado) > 0) { // Si se devuelve al menos un resultado...

                    while($row = mysqli_fetch_assoc($resultado)) {
                        
                        // Se crea el objeto de la plantilla
                        $plantillaUsuario = new Plantilla($row['idPlantilla'], $row['titulo'], $row['anio'], $row['formacion'], $row['datosPlantilla'], $row['idUsuario'], $row['idEquipo']);
                    }
    
                } else { // Si algo va mal lo dirige a la página de mis partidos

                    header("Location: ../controller/plantillas_mis.php");
                    die();
                }
                
                return $plantillaUsuario;
            }
            
            return "";
        }

        public static function recogerPlantillasUsuario(int $idUsuario, bool $condicion): array {

            $plantillasUsuario = [];
        
            $conexion = FrancisGolBD::establecerConexion();
        

            if ($condicion) { // Selecciono la consulta dependiendo de si se quiere ver mis plantilas o las de los usuarios

                $consulta = $conexion->prepare("SELECT * FROM plantilla WHERE idUsuario = ?");

            } else {

                $consulta = $conexion->prepare("SELECT * FROM plantilla WHERE idUsuario != ?");
            }
        
            $consulta->bind_param('i', $idUsuario);
            $consulta->execute();
            $resultado = $consulta->get_result();
        
            if ($resultado->num_rows > 0) {

                while ($row = $resultado->fetch_assoc()) { // Se recogen todas las plantillas y se crea un array de objetos

                    $plantillasUsuario[] = new Plantilla($row['idPlantilla'], $row['titulo'], $row['anio'], $row['formacion'], $row['datosPlantilla'], $row['idUsuario'], $row['idEquipo']);
                }
            }
        
            return $plantillasUsuario;
        }
        

        public function pintarPlantilla(string $accion): string { // Dependiendo de lo que se quiere ver se montará las etiquetas HTML con mis plantillas o con las del usuario

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
        public static function comprobarDatosJugadores(string $formacion, array $posicionesJugadores,string $datosPlantilla): bool {
            
            $formaciones = self::$formaciones; // Recojo las formaciones disponibles

            if (in_array($formacion, $formaciones)) { // Si la que han pasado está en el array es que es válida

                $posiciones = Plantilla::generarClasesPosicionJugador($formacion); // Genera las clases necesarias, esto genera las clases de los juagdores del 11 inicial
                
            } else {

                return false;
            }
            
            foreach (json_decode($datosPlantilla)->response[0]->players as $numeroJugador => $jugador) { // Recorro los jugadores
        
                if($numeroJugador >= 11 && $numeroJugador < 23) { // Recorro los suplentes
                    
                    array_push($posiciones, "suplentes_$numeroJugador");
        
                } else if($numeroJugador >= 23) {  // Recorro los no convocados
        
                    array_push($posiciones, "no_convocado_$numeroJugador");
                }
        
                if (!array_key_exists($jugador->id, $posicionesJugadores)) { // Si un jugador enviado no está en el JSON de los datos de esa plantilla es que se han modificado los datos

                    return false;
                }
            }
        
            // La idea de esto escomprobar que la plantilla tenga las clases que debería tener por seleccioanr la formación y el equipo, si se cambió o eliminó una clase o un dato de uno de los jugadores, retorna false

            foreach ($posicionesJugadores as $posicionesJugador) { 
                
                if (!in_array($posicionesJugador, $posiciones)) { // Se comprueba si las posiciones de los jugadores existen en el JSON, si falta alguna es que está mal

                    return false;
                    
                } else {

                    unset($posiciones[array_search($posicionesJugador,$posiciones)]); // Voy eliminando las clases que se comprueben por si se modificó alguna clase a otra que ya existía
                }
        
            }
        
            return true;
        }
        
        public static function guardarDatosJugadores(array $posicionesJugadores, string $titulo, string $formacion, string $datosPlantilla): int {
            
            $conexion = FrancisGolBD::establecerConexion();
        
            $usuario = unserialize($_SESSION['usuario']); // Recojo el objeto del usuario
            $idUsuario = $usuario->__get("id");

            $anio = date("Y") - 1; // Recojo el año actual
            $equipo = json_decode($datosPlantilla)->response[0]->team;
            $idEquipo = $equipo->id;
        
            $equipo = new Equipo($idEquipo, $equipo->name, $equipo->logo); // Creo el objeto del equipo
            $equipo->insertarEquipo(); // Guardo el equipo en la BBDD
        
            // Guardo todos los datos de la plantilla
            $consulta = $conexion->prepare("INSERT INTO plantilla (titulo, anio, formacion, datosPlantilla ,idUsuario, idEquipo)  VALUES (?, ?, ?, ?, ?, ?)");
            $consulta->bind_param("sissii", $titulo, $anio, $formacion, $datosPlantilla, $idUsuario, $idEquipo);
            $consulta->execute();
            
            $idPlantilla = mysqli_insert_id($conexion); // Recojo el id de la plantilla que se ha generado
        
            foreach (json_decode($datosPlantilla)->response[0]->players as $jugador) { // Recorro los jugadores
                
                //Recojo el id junto con la posición en la que se coloca
                $idJugador = $jugador->id;
                $posicion = $posicionesJugadores[$idJugador];
            
                $jugador = new Jugador($idJugador, $jugador->name, $jugador->photo); // Creo el objeto de los jugadores
                $jugador->insertarJugador(); // Guardo los datos de los jugadores en la BBDD
        
                // Guardo la posición jutno con el jugador en la BBDD
                $consulta = $conexion->prepare("INSERT INTO plantilla_jugador (idPlantilla,	idJugador,	posicion)  VALUES (?, ?, ?)");
                $consulta->bind_param("iis", $idPlantilla, $idJugador, $posicion);
                $consulta->execute();
        
            }
        
            return $idPlantilla;
        }

        /* FUNCIONES DE CREAR PLANTILLAS */

        public static function generarSelectFormaciones(string $formacionSeleccionada = "4-3-3"): string {
            
            $formaciones = self::$formaciones; // Recojo el array de formaciones disponibles
            $optionsFormaciones = "";

            foreach ($formaciones as $formacion) { // Recorro las formaciones y genero el HTML de los options
        
                if ($formacion == $formacionSeleccionada) {
        
                    $optionsFormaciones .= "<option value='$formacion' selected>$formacion</option>";
                } else {
        
                    $optionsFormaciones .= "<option value='$formacion'>$formacion</option>";
                }
        
            }

            return $optionsFormaciones;
        }
        
        public static function generarPlantilla(object $equipoPlantilla): string { // Genera la plantilla para CREAR
        
            $clasesJugador = Plantilla::generarClasesPosicionJugador("4-3-3");
        
            $alineacionPrincipal = "<div class='alineacion'><div class='formacion_equipo formacion_4-3-3'>";
            
            foreach ($equipoPlantilla->response[0]->players as $numeroJugador => $jugador) { // Recorro los juagdores
        
                if ($numeroJugador < 11) { // Genera los 11 primeros jugadores
                    
                    $alineacionPrincipal .= 
                    "<div class='".$clasesJugador[$numeroJugador]."' draggable='true' data-idJugador='{$jugador->id}'>
                        <img src='{$jugador->photo}' alt='foto'>
                        <p>{$jugador->name}</p>
                    </div>";
        
                } else if($numeroJugador < 23) { // Los suplentes
        
                    $alineacionPrincipal .= $numeroJugador == 11 ? "</div></div><p class='titulo_seccion'>Suplentes</p><section class='seccion_negra jugadores_suplentes'>" : "";
                    
                    $alineacionPrincipal .= "<div class='suplentes_".$numeroJugador."' draggable='true' data-idJugador='{$jugador->id}'>
                                                <img src='{$jugador->photo}' alt='foto'>
                                                <p>{$jugador->name}</p>
                                            </div>";
                } else { // Los no convocados
        
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
        
        public static function generarClasesPosicionJugador(string $formacion): array {
            
            $formacion = explode("-",$formacion); // Separo el string por el guion, Ejemplo con la 4-3-3 = array(4, 3, 3)
        
            $clasesGeneradas = ["jugador_1_1"]; // La primera clase siempre es del portero
        
            foreach ($formacion as $clave => $numeroJugadoresPosicion) { // Recorre los núemros de la formación
                
                for ($i=1; $i <= $numeroJugadoresPosicion; $i++) { // Crea las clases necesarias para la formación
                    
                    array_push($clasesGeneradas, "jugador_". $clave+2 ."_".$i);
                }
            }
        
            // Se genera algo así. Ejemplo con la 4-3-3
            //  1  -  jugador_1_1
            //  4  -  jugador_2_1,  jugador_2_2,  jugador_2_3,  jugador_2_4
            //  3  -  jugador_3_1,  jugador_3_2,  jugador_3_3
            //  3  -  jugador_4_1,  jugador_4_2,  jugador_4_3

            return $clasesGeneradas;
        }

        /* FUNCIONES PÁGINA DE EDITAR PLANTILLA */

        public function recogerDatosPlantilla(): array {

            $datosPlantilla = [];
            $idPlantilla = $this->__get("id"); // Recojo el is de la plantilla del objeto
            $conexion = FrancisGolBD::establecerConexion();

            // Recojo los datos dela plantilla y de los jugadores de la plantilla
            $consulta = "SELECT * 
                        FROM jugador ju
                        INNER JOIN plantilla_jugador pj
                        ON pj.idJugador = ju.idJugador
                        WHERE pj.idPlantilla = $idPlantilla";

            $resultado = $conexion->query($consulta);

            if (mysqli_num_rows($resultado) > 0) {
        
                while($row = mysqli_fetch_assoc($resultado)) { // Creo un array asociativo de posicion del juagdor => array de datos del jugador
                    
                    $datosPlantilla[$row['posicion']] = ["id" => $row['idJugador'], "nombre" => $row['nombre'], "foto" => $row['foto']];
                }
            }

            return $datosPlantilla;
        }

        public function pintarPlantillaEditar(array $datosPlantilla): string  {
            
            $formacion = $this->__get("formacion");

            $alineacion = "<div class='alineacion'><div class='formacion_equipo formacion_$formacion'>"; 
            
            $formaciones = Plantilla::generarClasesPosicionJugador($formacion); // Genero las formaciones para la plantilla recogida
            
            foreach ($formaciones  as $formacion) { // Recorro los jugadores del 11 inicial y creo su HTML

                $datosJugador = $datosPlantilla[$formacion];

                $alineacion .= "<div class='".$formacion."' draggable='true' data-idJugador='".$datosJugador["id"]."'>
                    <img src='".$datosJugador["foto"]."' alt='foto'>
                    <p>".$datosJugador["nombre"]."</p>
                </div>";
            }

            $alineacion .= "</div></div><p class='titulo_seccion'>Suplentes</p><section class='seccion_negra jugadores_suplentes'>";

            for ($i = 11; $i < 23; $i++) { // Genero el HTML de los suplentes
                
                $datosJugador = $datosPlantilla["suplentes_$i"];

                $alineacion .= "<div class='suplentes_".$i."' draggable='true' data-idJugador='".$datosJugador["id"]."'>
                                    <img src='".$datosJugador["foto"]."' alt='foto'>
                                    <p>".$datosJugador["nombre"]."</p>
                                </div>";
            }

            $alineacion .= "</section><p class='titulo_seccion'>No convocados</p><section class='seccion_negra jugadores_suplentes'>";


            for ($i = 23; $i < count($datosPlantilla); $i++) {  // Genero el HTML de los no convocados
                
                $datosJugador = $datosPlantilla["no_convocado_$i"];

                $alineacion .= "<div class='no_convocado_".$i."' draggable='true' data-idJugador='".$datosJugador["id"]."'>
                                    <img src='".$datosJugador["foto"]."' alt='foto'>
                                    <p>".$datosJugador["nombre"]."</p>
                                </div>";
            }

            $alineacion .= "</section>";

            return $alineacion;
        }

        public function actualizarDatosJugadores(array $posicionesJugadores, string $titulo, string $formacion): string {

            $idPlantilla = $this->__get("id");
            $conexion = FrancisGolBD::establecerConexion();

            try { 

                // Actualizo los datos de la plantilla en la BBDD
                $consulta = $conexion->prepare("UPDATE plantilla SET titulo = ?, formacion = ? WHERE idPlantilla = ?");
                $consulta->bind_param("ssi", $titulo, $formacion, $idPlantilla);
                $consulta->execute();
    
                foreach ($posicionesJugadores as $idJugador => $posicion) { // Actualizo las posiciones de sus jugadores
    
                    $consulta = $conexion->prepare("UPDATE plantilla_jugador SET posicion = ? WHERE idPlantilla = ? AND idJugador = ?");
                    $consulta->bind_param("sii", $posicion, $idPlantilla, $idJugador);
                    $consulta->execute();
                    
                }
    
            } catch (mysqli_sql_exception) { // Si algo falla muestra el mensaje de error

                return "No se pudieron actualizar los datos";
            }

            return "Plantilla editada correctamente";
        }

        /* FUNCIONES BORRAR PLANTILLA */

        public function borrarPlantilla() {
            
            $idPlantilla = $this->__get("id");
            $conexion = FrancisGolBD::establecerConexion();

            // Realizo la consulta para eliminar la plantilla, todos los datos se eliminan en Cascada por tanto con eliminar la plantilla también se borran las posiciones de los juagdores en la plantilla
            $consulta = $conexion->prepare("DELETE FROM plantilla WHERE idPlantilla = ?");
            $consulta->bind_param("i", $idPlantilla);
            $consulta->execute();

        }
    }