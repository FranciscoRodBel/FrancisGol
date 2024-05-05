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

    public static function insertarCompeticion($idCompeticion, $idUsuario) {

        $conexion = FrancisGolBD::establecerConexion();

        $consulta = $conexion->prepare("INSERT INTO competicion_favorita (idUsuario, idCompeticion)  VALUES (?, ?)");
        $consulta->bind_param("ii", $idUsuario, $idCompeticion);
        $consulta->execute();
    }

    public static function insertarEquipo($idEquipo, $idUsuario) {

        $conexion = FrancisGolBD::establecerConexion();

        $consulta = $conexion->prepare("INSERT INTO equipo_favorito (idUsuario, idCompeticion)  VALUES (?, ?)");
        $consulta->bind_param("ii", $idUsuario, $idEquipo);
        $consulta->execute();
    }

    public static function eliminarCompeticion($idCompeticion, $idUsuario) {

        $conexion = FrancisGolBD::establecerConexion();

        $consulta = $conexion->prepare("DELETE FROM competicion_favorita WHERE idUsuario = ? AND idCompeticion = ?");
        $consulta->bind_param("ii", $idUsuario, $idCompeticion);
        $consulta->execute();
    }

    public static function eliminarEquipo($idEquipo, $idUsuario) {

        $conexion = FrancisGolBD::establecerConexion();

        $consulta = $conexion->prepare("DELETE FROM equipo_favorito WHERE idUsuario = ? AND idEquipo = ?");
        $consulta->bind_param("ii", $idUsuario, $idEquipo);
        $consulta->execute();
    }
    
}