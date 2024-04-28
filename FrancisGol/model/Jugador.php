<?php
    class Jugador {
        
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

        public static function recogerJugador($idJugador) {
        
            $jugador = realizarConsulta("jugador_$idJugador", "/players?id=$idJugador&season=2023", 86400);
            $datos_jugador = $jugador;
            
            $jugador = $jugador->response[0]->player;
            $jugador = new Jugador($jugador->id, $jugador->name, $jugador->photo);

            $datosJugador = '<div class="competicion_equipo">
                <a>
                    <img src="'.$jugador->logo.'" alt="Logo">
                    <span>'.$jugador->nombre.'</span>
                </a>
                <i class="fa-solid fa-star icono_estrella"></i>
            </div><hr>';

            return [$datosJugador, $datos_jugador];
        }
        
    }