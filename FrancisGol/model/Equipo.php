<?php

class Equipo {
    
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

    public static function recogerEquipo($idEquipo) {
    
        if (isset($_SESSION["equipo".$idEquipo])) {

            // $equipo  = unserialize(json_decode($_SESSION["equipo".$idEquipo]));

        } else {

            $equipo = recogerEquipo($idEquipo);

            $equipo = $equipo->response[0]->team;
            $equipo = new Equipo($equipo->id, $equipo->name, $equipo->logo);
            $_SESSION["equipo".$idEquipo] = serialize(json_encode($equipo));
        }

        $datosEquipo = '<div class="competicion_equipo">
            <a>
                <img src="'.$equipo->logo.'" alt="Logo">
                <span>'.$equipo->nombre.'</span>
            </a>
            <i class="fa-solid fa-star icono_estrella"></i>
        </div><hr>';

        return $datosEquipo;
    }
    
}