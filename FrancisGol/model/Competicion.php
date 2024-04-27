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
        
            if (isset($_SESSION["competicion".$idCompeticion])) {

                $competicion  = unserialize(json_decode($_SESSION["competicion".$idCompeticion]));

            } else {
                
                $competicion = realizarConsulta("competicion_$idCompeticion", "leagues?id=$idCompeticion", 86400); 
                $competicion = $competicion->response[0]->league;
                $competicion = new Competicion($competicion->id, $competicion->name, $competicion->logo);
                $_SESSION["competicion".$idCompeticion] = serialize(json_encode($competicion));
            }

            $datosCompeticion = '<div class="competicion_equipo">
                <a>
                    <img src="'.$competicion->logo.'" alt="Logo">
                    <span>'.$competicion->nombre.'</span>
                </a>
                <i class="fa-solid fa-star icono_estrella"></i>
            </div><hr>';

            return $datosCompeticion;
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
        
    }