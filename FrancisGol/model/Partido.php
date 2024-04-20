<?php

class Partido {
    
    public function __construct(
        protected int $id,
        protected string $nombreEquipoLocal,
        protected string $nombreEquipoVisitante,
        protected string $escudoEquipoLocal,
        protected string $escudoEquipoVisitante,
        protected string $resultadoHora
    ) {}

    public function __get(string $propiedad) {
        return $this->$propiedad;
    }

    public function __set(string $propiedad, $valor) {
        $this->$propiedad = $valor;
    }

    
}