<?php

require_once 'FrancisGolBD.php';
require_once 'funciones.inc.php';

class Usuario { // Se usa para manejar todos los datos del usuario
    protected int $id;
    protected string $email;
    protected string $nombre;
    protected string $foto;
    
    public function __construct($email) {
        $this->email = $email;
    }

    public function __get(string $propiedad) {
        return $this->$propiedad;
    }

    public function __set(string $propiedad, $valor) {
        $this->$propiedad = $valor;
    }

    // Inicio de sesión

    public function comprobarInicioSesion($contrasenia) {
        $conexion = FrancisGolBD::establecerConexion();
        $email = $this->__get("email");
    
        // Busco el email del usuario y recojo su contraseña
        $consulta = $conexion->stmt_init();
        $consulta->prepare("SELECT * FROM usuario WHERE email = ?");
        $consulta->bind_param("s", $email);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $resultado = $resultado->fetch_assoc();

        if (!empty($email)) {
            // Compruebo si la contraseña es la misma
            if ($resultado !== null && password_verify($contrasenia, $resultado["contrasenia"])) {
                
                // Si es la misma contraseña relleno las propiedades del objeto
                $this->__set("id", $resultado["idUsuario"]);
                $this->__set("nombre", $resultado["nombre"]);
                $this->__set("foto", $resultado["foto"]);

                session_start();
                $_SESSION['usuario'] = serialize($this); // guardo el propio objeto en la sesión de usuario
                header('Location: ./partidos.php');
                die();
            }
        }
    
        return "Email o contraseña incorrecta";
    }    

     // Registro de cuenta
     public function emailEnUso()  { // comprueba si el email ya está en la base de datos
        $conexion = FrancisGolBD::establecerConexion();
        $email = $this->__get('email');
    
        // Busca por el email enviado
        $consulta = $conexion->prepare("SELECT * FROM usuario WHERE email = ?");
        $consulta->bind_param("s", $email);
        $consulta->execute();

        return empty($consulta->fetch()); // Devuelve true si está vacío (que no está en uso)
    }

    public function nombreEnUso($nombre)  { // comprueba si el teléfono ya está en la base de datos
        $conexion = FrancisGolBD::establecerConexion();
    
        $consulta = $conexion->prepare("SELECT * FROM usuario WHERE nombre = ?");
        $consulta->bind_param("s", $nombre);
        $consulta->execute();

        return empty($consulta->fetch()); // Devuelve true si está vacío (que no está en uso)
    }

    public function guardarDatosUsuario($email, $nombre, $contrasenia, $foto) {
        $conexion = FrancisGolBD::establecerConexion();
        
        $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT); // cifra la contraseña del usuario

        // Añade el usuario en la base de datos
        $consulta = $conexion->prepare("INSERT INTO usuario (email, nombre, contrasenia, foto) VALUES (?, ?, ?, ?)");
        $consulta->bind_param("sssb", $email, $nombre, $contrasenia, $foto);
        $consulta->execute();

        $conexion->close();
    }
   
    public function comprobarRegistro($email, $nombre, $contraseniaUno, $contraseniaDos, $foto) {
        
        $email = comprobarDatos($email);
        $nombre = comprobarDatos($nombre);
        $contraseniaUno = comprobarDatos($contraseniaUno);
        $contraseniaDos = comprobarDatos($contraseniaDos);

        if (comprobarVacio(array($nombre, $email, $contraseniaUno, $contraseniaDos))) {
            
            if ($this->emailEnUso()) { // Si el email no está en uso continua

                if ($this->nombreEnUso($nombre)) { // Si el teléfono no está en uso continua

                        if (!is_numeric($nombre)) { // Si el nombre no es un número continua

                            if ($contraseniaUno == $contraseniaDos) {
        
                                // Si los datos están bien los guarda en el usuario
                                $this->guardarDatosUsuario($nombre, $email, $contraseniaUno, $foto);
                                
                                return "Cuenta Creada";
                
                            } else {
                                return "Las contraseñas no coinciden";
                
                            }

                        } else {
                            return "Nombre incorrecto";
                        }
        
                } else {
                    return "El nombre ya está en uso";
        
                }
    
            } else {
                return "El email ya está en uso";
    
            }

        } else {
            return "Formulario incompleto";
        }

    }

    public static function recogerUsuario($idUsuario) {
        $conexion = FrancisGolBD::establecerConexion();

        // Recogerá un único usuario, a través del id pasado por parámetro
        $consulta = "SELECT * FROM usuario WHERE idUsuario=".$idUsuario;
        $resultado = $conexion->query($consulta);
        
        $usuarios = [];
        
        // Guarda el usuario en un array
        while ($usuario = $resultado->fetch_assoc()) {

            // Creo el objeto y luego seteo sus propiedades
            $ObjetoUsuario = new Usuario($usuario["email"]);
            $ObjetoUsuario->__set("id", $usuario["idUsuario"]);
            $ObjetoUsuario->__set("nombreCompleto", $usuario["nombreCompleto"]);
            $ObjetoUsuario->__set("fechaNacimiento", $usuario["fechaNacimiento"]);
            $ObjetoUsuario->__set("telefono", $usuario["telefono"]);

            $usuarios[] = $ObjetoUsuario;
        }
    
        return $usuarios;  
    }
}
?>
