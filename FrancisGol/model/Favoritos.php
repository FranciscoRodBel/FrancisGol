<?php

require_once 'FrancisGolBD.php';
require_once 'funciones.inc.php';

class Favoritos { // Se usa para manejar todos los datos del usuario
    protected array $equiposCompeticiones;
    
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

        $consulta = $conexion->prepare("INSERT INTO equipo_favorito (idUsuario, idEquipo)  VALUES (?, ?)");
        $consulta->bind_param("ii", $idUsuario, $idEquipo);
        $consulta->execute();
    }

    public static function eliminarCompeticion($idCompeticion, $idUsuario) {

        $conexion = FrancisGolBD::establecerConexion();

        $consulta = "SELECT * FROM competicion_favorita WHERE idUsuario = $idUsuario";
        $resultado = $conexion->query($consulta);
        if (mysqli_num_rows($resultado) == 1) return false;

        $consulta = $conexion->prepare("DELETE FROM competicion_favorita WHERE idUsuario = ? AND idCompeticion = ?");
        $consulta->bind_param("ii", $idUsuario, $idCompeticion);
        return $consulta->execute();
    }

    public static function eliminarEquipo($idEquipo, $idUsuario) {

        $conexion = FrancisGolBD::establecerConexion();

        $consulta = "SELECT * FROM equipo_favorito WHERE idUsuario = $idUsuario";
        $resultado = $conexion->query($consulta);
        if (mysqli_num_rows($resultado) == 1) return false;

        $consulta = $conexion->prepare("DELETE FROM equipo_favorito WHERE idUsuario = ? AND idEquipo = ?");
        $consulta->bind_param("ii", $idUsuario, $idEquipo);
        return $consulta->execute();
        
    }

    public static function recogerCompeticionFavorito() {
        
        if (isset($_SESSION['usuario'])) {
            
            $usuario = unserialize($_SESSION['usuario']);
            $idUsuario = $usuario->__get("id");
    
            $conexion = FrancisGolBD::establecerConexion();
    
            $arrayFavoritos = new Favoritos();
    
            $consulta = "SELECT * FROM competicion_favorita WHERE idUsuario = $idUsuario";
            $resultado = $conexion->query($consulta);
    
            while ($row = $resultado->fetch_assoc()) {

                $arrayFavoritos->equiposCompeticiones[] = $row["idCompeticion"];
            }
            
            return $arrayFavoritos;
        }
    }
    
    public static function recogerEquiposFavorito() {

        if (isset($_SESSION['usuario'])) {

            $usuario = unserialize($_SESSION['usuario']);
            $idUsuario = $usuario->__get("id");
    
            $conexion = FrancisGolBD::establecerConexion();
    
            $arrayFavoritos = new Favoritos();
    
            $consulta = "SELECT * FROM equipo_favorito WHERE idUsuario = $idUsuario";
            $resultado = $conexion->query($consulta);
    
            while ($row = $resultado->fetch_assoc()) {

                $arrayFavoritos->equiposCompeticiones[] = $row["idEquipo"];
            }
            
            return $arrayFavoritos;
        }
    }
}