<?php

require_once 'FrancisGolBD.php';
require_once 'funciones.inc.php';

class Favoritos { // Se usa para manejar todos los datos del usuario
    protected array $equipos;
    protected array $competicones;
    
    public function __get(string $propiedad) {
        return $this->$propiedad;
    }

    public function __set(string $propiedad, $valor) {
        $this->$propiedad = $valor;
    }
}