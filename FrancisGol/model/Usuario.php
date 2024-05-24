<?php
session_start(); 

require_once 'FrancisGolBD.php';
require_once 'funciones.inc.php';
require_once "../controller/cookies.php";

class Usuario { // Se usa para manejar todos los datos del usuario
    protected int $id;
    protected string $email;
    protected string $nombre;
    protected string $foto;
    protected string $cookies;
    
    public function __construct($email) {
        $this->email = $email;
    }

    public function __get(string $propiedad) {
        return $this->$propiedad;
    }

    public function __set(string $propiedad, $valor) {
        $this->$propiedad = $valor;
    }

    public static function recogerNombreUsuario(int $idUsuario): string {

        $conexion = FrancisGolBD::establecerConexion();

        // Busco el nombre del jugador pasado, esto se utiliza en la página de ver plantilla usuario para mostrar el nombre del creador de la plantilla
        $consulta = "SELECT nombre FROM usuario WHERE idUsuario = $idUsuario";
        $resultado = $conexion->query($consulta);
        $fila = $resultado->fetch_assoc();
        $nombreUsuario = $fila['nombre'];

        return $nombreUsuario;
    }

    // Inicio de sesión

    public function comprobarInicioSesion(string $contrasenia, string $tipo): string {

        $conexion = FrancisGolBD::establecerConexion();
        $email = $this->__get("email");

        // Busco por el email del usuario y recojo su contraseña
        $consulta = $conexion->stmt_init();
        $consulta->prepare("SELECT * FROM usuario WHERE email = ?");
        $consulta->bind_param("s", $email);
        $consulta->execute();
        $resultado = $consulta->get_result();
        $resultado = $resultado->fetch_assoc();

        if (!empty($email) && $this->emailEnUso()) { // Si el email es válido

            if ($tipo == "cookie") { // Si estoy iniciando sesión con la cookie, comparo contraseña cifrada de la BBDD con contraseña cifrada de la Cookie

                $comprobacionContrasenia = $resultado["contrasenia"] == $contrasenia;

            } else { // Si es el inicio de sesión normal, compruebo contraseña cifrada de la BBDD con contraseña no cifrada introducida

                $comprobacionContrasenia = password_verify($contrasenia, $resultado["contrasenia"]);
            }

            if ($resultado !== null && $comprobacionContrasenia) {
                
                // Si la contraseña del email es correcta relleno las propiedades del objeto
                $this->__set("id", $resultado["idUsuario"]);
                $this->__set("nombre", $resultado["nombre"]);
                $this->__set("foto", $resultado["foto"]);
                $this->__set("cookies", $resultado["cookies"]);

                if ($this->__get("cookies") == 1) $this->crearCookies();

                $_SESSION['usuario'] = serialize($this); // guardo el propio objeto en la sesión de usuario

                return "";
            }
            
        }
    
        return "<p class='titulo_informacion'>Email o contraseña incorrecta</p>";
    }    

     // Registro de cuenta
     public function emailEnUso(): bool  { // comprueba si el email ya está en la base de datos
        $conexion = FrancisGolBD::establecerConexion();
        $email = $this->__get('email');
    
        // Busca por el email enviado
        $consulta = $conexion->prepare("SELECT * FROM usuario WHERE email = ?");
        $consulta->bind_param("s", $email);
        $consulta->execute();

        return !empty($consulta->fetch()); // Devuelve true si está con datos (que está en uso)
    }

    public function nombreEnUso(string $nombre): bool  { // comprueba si el nombre ya está en la base de datos
        $conexion = FrancisGolBD::establecerConexion();
    
        $consulta = $conexion->prepare("SELECT * FROM usuario WHERE nombre = ?");
        $consulta->bind_param("s", $nombre);
        $consulta->execute();

        return !empty($consulta->fetch()); // Devuelve true si está con datos (que está en uso)
    }

    public function guardarDatosUsuario(string $email, string $nombre, string $contrasenia, string $foto): int|bool {
        $conexion = FrancisGolBD::establecerConexion();
        
        // Cifra la contraseña del usuario
        $contrasenia = password_hash($contrasenia, PASSWORD_DEFAULT);
        
        $consulta = "INSERT INTO usuario (email, nombre, contrasenia, foto, cookies) VALUES ('$email', '$nombre', '$contrasenia', '$foto', 0)";

        $resultado = $conexion->query($consulta);
        $idUsuario = mysqli_insert_id($conexion);

        // Devuelve o el id del usuario o false
        if ($resultado) return $idUsuario;

        return $resultado;
    }
    
    public function comprobarRegistro(string $email, string $nombre, string $contraseniaUno, string $contraseniaDos, array $competicionesFavoritas, array $equipoFavoritas): string {
        
        $email = comprobarDatos($email);
        $nombre = comprobarDatos($nombre);
        $contraseniaUno = comprobarDatos($contraseniaUno);
        $contraseniaDos = comprobarDatos($contraseniaDos);

        // Comprueba que todos los datos que llegan son los que se esperaban
        if (!comprobarVacio(array($nombre, $email, $contraseniaUno, $contraseniaDos))) return "El formulario está incompleto";
        
        if (is_numeric($nombre)) return "Nombre incorrecto";
        
        if ($contraseniaUno != $contraseniaDos) return "Las contraseñas no coinciden";

        if (!preg_match("/(?=.*[a-zA-Z].*)^[\w.]{5,25}$/i", $nombre)) return "Nombre incorrecto, debe estar compuesto por letras, números, puntos o guiones bajos entre 5 y 25 caracteres.";

        if (!preg_match("/(?=^.{5,70}$)[\w]+@[\w]+\.[\w]+/i", $email)) return "Email incorrecto, debe estar compuesto por caracteres(letras, números o guiones bajos) una @ seguido de caracteres, un punto y caracteres, hasta 70 caracteres.";

        if (!preg_match("/(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)^[\w\W]{8,50}$/", $contraseniaUno)) return "Contraseña incorrecta, debe estar compuesto mínimo por una letra mayúscula, minúscula, un número y un caracter extraño entre 8 y 50 caracteres.";

        if ($this->emailEnUso()) return "El email ya está en uso";
        
        if ($this->nombreEnUso($nombre)) return "El nombre ya está en uso";

        $foto = $this->generarFoto(); // Genera el blob de la foto

        if ($foto == "mal_formato") return "El formato de las fotos no es correcto";

        $idUsuario = $this->guardarDatosUsuario($email, $nombre, $contraseniaUno, $foto);
        
        if (empty($idUsuario)) {

            return "Error al guardar los datos";
            
        } else {

            // Recorro los equipos y las competiciones favoritas y las guarda en la BBDD
            foreach ($competicionesFavoritas as $idCompeticion) { 

                Competicion::insertarCompeticionFavorita($idCompeticion, $idUsuario);
            }

            foreach ($equipoFavoritas as $idEquipo) {
                
                Equipo::insertarEquipoFavorito($idEquipo, $idUsuario);
            }

        }

        return "Cuenta Creada";
    }

    public function generarFoto(): string {
    
        $rutaTemporal = $_FILES['inputFoto']['tmp_name']; // Obtén la ruta temporal del archivo
    
        if ($rutaTemporal == "") { // Si está vacía es que no se ha enviado la foto

            if (isset($_SESSION['usuario'])) {
                
                return "sin_cambios"; // Si está editando y no selecciona nada no cambia la foto

            } else { // Si no se envía la foto le añado una imagen predeterminada
                
                $archivo = addslashes(file_get_contents("../view/assets/images/foto_perfil.png"));
            }

        } else {

            // Del nombre del archivo recojo la extensión del archivo
            $nombreArchivo = basename($_FILES['inputFoto']['name']);
            $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        
            if (!in_array($extension, ["png", "jpeg", "jpg"])) { // Si el tipo de archivo no es válido devuelve mal_formato
                
                return "mal_formato";
            }

            $archivo = addslashes(file_get_contents($rutaTemporal)); // Devuelve la imagen en formato binario para guardarlo en el longblob

        }
    
        return $archivo;
    }

    public static function comprobarSesionIniciada(bool $operacion) { // Se usa para redirigir a una página cuando esté o no la sesión iniciada

        if ($operacion) {
    
            // Que si la sesión está iniciada lo devuelva a la página de partidos, se usa en páginas de iniciar sesión y registro
            if (isset($_SESSION['usuario'])) {
            
                header('Location: ./partidos.php');
                die();
            
            }
        
        } else {
            
            // Que si la sesión no está iniciada que lo reenvíe a la página de partidos, en cualquier página en la que cambie la base de datos
            if (!isset($_SESSION['usuario'])) {
            
                header('Location: ./partidos.php');
                die();
            
            }
        }
    }

    /* FUNCIONES COOKIES */
    public function generarMensajeCookies() {
        
        $mensajeCookie = '<div class="seccionCookies" id="seccionCookies">
                <p>Acepte las cookies para mantener su sesión iniciada y mejorar su experiencia en nuestra web.</p>
                <div>
                    <a id="rechazarCookies" class="boton_gris">Rechazar</a>
                    <a id="aceptarCookies" class="boton_verde">Aceptar</a>
                </div>
            </div>';
        
        return $mensajeCookie;

    }

    public function guardarCookies() { // Cambia el valor de cookies a 1 para saber que aceptó las cookies
        
        $conexion = FrancisGolBD::establecerConexion();

        $consulta = "UPDATE usuario SET cookies = 1 WHERE idUsuario = ".$this->__get("id");
        $conexion->query($consulta);

    }

    public function crearCookies() { // Las crea para un mes

        $email = $this->__get("email");
        $contrasenia = $this->recogerContrasenia();
        
        setcookie("email", $email, time() + 86400 * 30, "/"); 
        setcookie("contrasenia", $contrasenia, time() + 86400 * 30, "/");
    }

    public function recogerContrasenia() {

        $conexion = FrancisGolBD::establecerConexion();

        // Se usa para recoger la contraseña cifrada del usuario de la cookie
        $consulta = "SELECT contrasenia FROM usuario WHERE idUsuario = ".$this->__get("id");
        $resultado = $conexion->query($consulta);
        $fila = $resultado->fetch_assoc();
        $contrasenia = $fila['contrasenia'];

        return $contrasenia;
    }

    public function editarFoto(): string {

        $foto = $this->generarFoto();

        if ($foto == "mal_formato") return "El formato de la foto no es correcto";

        if ($foto == "sin_cambios") return "Tiene que seleccionar una foto";

        return $this->actualizarFotoUsuario($foto); // Guarda la foto en la BBDD
    }

    public function actualizarFotoUsuario(string $foto) {

        $conexion = FrancisGolBD::establecerConexion();
    
        $idUsuario = $this->__get("id");
        
        $consulta = "UPDATE usuario SET foto = '$foto' WHERE idUsuario = $idUsuario";
        
        $resultado = $conexion->query($consulta); // Ejecutamos la consulta
     
        if ($resultado) { // Si la foto se fuarda correctamente, recojo la foto de la BBDD y la guardo en el objeto(si directamente guardo la foto en el objeto no se visualiza la foto en la página)

            $consulta = $conexion->stmt_init();
            $consulta->prepare("SELECT * FROM usuario WHERE idUsuario = ?");
            $consulta->bind_param("s", $idUsuario);
            $consulta->execute();
            $resultado = $consulta->get_result();
            $resultado = $resultado->fetch_assoc();

            $this->__set("foto", $resultado['foto']);
            $_SESSION['usuario'] = serialize($this);

            return "Foto de perfil actualizada";

        } else {

            return "No se pudo cambiar la foto";
        }
    }

    public function editarDatos(): string {

        if (!isset($_POST["email"]) || !isset($_POST["nombre"]) || !isset($_POST["contrasenia"])) return "No se enviaron los datos";
        // Si se enviaron los datos...

        // Compruebo que los datos no tienen ninguna inyección SQL
        $email = comprobarDatos($_POST["email"]);
        $nombre = comprobarDatos($_POST["nombre"]);
        $contrasenia = $_POST["contrasenia"];
        $nombreActual = $this->__get("nombre");
        $emailActual = $this->__get("email");
    
        if (!preg_match("/(?=.*[a-zA-Z].*)^[\w.]{5,25}$/i", $nombre)) return "Nombre incorrecto, debe estar compuesto por letras, números, puntos o guiones bajos entre 5 y 25 caracteres.";

        if (!preg_match("/(?=^.{5,70}$)[\w]+@[\w]+\.[\w]+/i", $email)) return "Email incorrecto, debe estar compuesto por caracteres(letras, números o guiones bajos) una @ seguido de caracteres, un punto y caracteres entre 5 y 70 caracteres.";

        $nuevoUsuario = new Usuario($email); // Creo el usuario
        $nuevoUsuario->__set("nombre", $nombre); // Le añado el nombre al objeto

        // Compruebo que el nuevo email y nombre son correctos
        if ($emailActual != $email && $nuevoUsuario->emailEnUso()) return "El email ya está en uso";
        
        if ($nombreActual != $nombre && $nuevoUsuario->nombreEnUso($nombre)) return "El nombre ya está en uso";

        $contraseniaUsuario = $this->recogerContrasenia(); // Compruebo que la contraseña introducida es apta para cambiar los datos
        if (!password_verify($contrasenia, $contraseniaUsuario)) return "La contraseña no es correcta";

        return $this->actualizarDatosUsuario($email, $nombre);
    }
    public function actualizarDatosUsuario(string $email, string $nombre) {
        
        $conexion = FrancisGolBD::establecerConexion();
        $idUsuario = $this->__get("id");
        
        $consulta = "UPDATE usuario SET email = '$email', nombre = '$nombre'  WHERE idUsuario = $idUsuario";
        
        $resultado = $conexion->query($consulta); // Actualizo los datos
     
        if ($resultado) {

            $this->__set("nombre", $nombre);
            $this->__set("email", $email);
            $_SESSION['usuario'] = serialize($this); // Actualizo el objeto del usuario de la sesión con los nuevos datos

            setcookie("email", $email, time() + 86400 * 30, "/"); // Actualizo los datos de la cookie

            return "Datos actualizados";

        } else {

            return "No se pudieron actualizar los datos";
        }
    }

    public function editarContrasenia(): string {
        
        if (!isset($_POST["nueva_contrasenia"]) || !isset($_POST["contrasenia_actual"]) || !isset($_POST["repetir_contrasenia"])) return "No se enviaron los datos";
        // Si se enviaron los datos...

        // Recojo los datos
        $nuevaContrasenia = $_POST["nueva_contrasenia"];
        $repetirContrasenia = $_POST["repetir_contrasenia"];
        $contraseniaActual = $_POST["contrasenia_actual"];

        if ($nuevaContrasenia != $repetirContrasenia) return "Las contraseñas nuevas no coinciden";

        $contraseniaUsuario = $this->recogerContrasenia(); // recojo la contraseña actual del usuario para comprobar que puede cambiar la contraseña

        if (!password_verify($contraseniaActual, $contraseniaUsuario)) return "La contraseña acutal no es correcta";

        if (!preg_match("/(?!.*\s.*)(?=.*[0-9].*)(?=.*[a-z].*)(?=.*[A-Z].*)(?=.*[\W_].*)^[\w\W]{8,50}$/", $nuevaContrasenia)) return "Nueva contraseña incorrecta, debe estar compuesto mínimo por una letra mayúscula, minúscula, un número y un caracter extraño entre 8 y 50 caracteres.";

        return $this->actualizarContraseniaUsuario($nuevaContrasenia); // Si todo es correcto guardo los datos en la BBDD
    }

    public function actualizarContraseniaUsuario(string $nuevaContrasenia): string {
        
        $nuevaContrasenia = password_hash($nuevaContrasenia, PASSWORD_DEFAULT); // Cifro la contraseña

        $conexion = FrancisGolBD::establecerConexion();
        $idUsuario = $this->__get("id");
        
        $consulta = "UPDATE usuario SET contrasenia = '$nuevaContrasenia'  WHERE idUsuario = $idUsuario";
        
        $resultado = $conexion->query($consulta); // Ejecutamos la consulta
     
        if ($resultado) {

            setcookie("contrasenia", $nuevaContrasenia, time() + 86400 * 30, "/"); // Si la contraseña es correcta actualizo la cookie
            return "Contraseña actualizada";

        } else {

            return "No se pudo actualizar la contraseña";
        }
    }

    /* Funciones borrado de cuenta */
    public function borrarCuenta() {
       
        $conexion = FrancisGolBD::establecerConexion();

        $idUsuario = $this->__get("id");

        $consulta = $conexion->prepare("DELETE FROM usuario WHERE idUsuario = ?");
        $consulta->bind_param("i", $idUsuario);
        
        $consulta->execute();
        $consulta->close();
    }
}