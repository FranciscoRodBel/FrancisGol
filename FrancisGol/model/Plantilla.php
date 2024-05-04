<?php
    class Plantilla {
        public function __construct(
            protected int $id,
            protected string $titulo,
            protected int $anio,
            protected string $formacion,
            protected int $idEquipo,
            protected string $escudo,
            protected int $idUsuario
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
                    
                    $plantillaUsuario = new Plantilla($row['idPlantilla'], $row['titulo'], $row['anio'], $row['formacion'], $row['idEquipo'], $row['escudo'], $row['idUsuario']);
                }

            } else {
                $plantillaUsuario = "";
            }
        
            return $plantillaUsuario;
        }

        public static function recogerPlantillasUsuario($idUsuario) {
    
            $conexion = FrancisGolBD::establecerConexion();
        
            $consulta = "SELECT * FROM plantilla WHERE idUsuario = $idUsuario";
        
            $resultado = $conexion->query($consulta);
        
            if (mysqli_num_rows($resultado) > 0) {
        
                while($row = mysqli_fetch_assoc($resultado)) {
                    
                    $plantillasUsuario[] = new Plantilla($row['idPlantilla'], $row['titulo'], $row['anio'], $row['formacion'], $row['idEquipo'], $row['escudo'], $row['idUsuario']);
                }

            } else {
                $plantillasUsuario = [];
            }
        
            return $plantillasUsuario;
        }

        public function pintarPlantilla() {
    
            $plantilla = "<div class='mi_plantilla'>
                            <a href='../controller/plantillas_editar.php?plantilla={$this->__get('id')}'>
                                <div>
                                    <img src='{$this->__get('escudo')}' alt='escudo'>
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

    }