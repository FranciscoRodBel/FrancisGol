<?php
    class FrancisGolBD { // Clase para hacer la conexión a la base de datos
        protected static $conexion; // Almacena la conexión
        public static function establecerConexion(): object { // Es estática por tanto se puede llamar sin tener el objeto creado

            if (!isset(self::$conexion)) {
                $server = "localhost";
                $usuario = "root";
                $contrasenia = "root";
                $baseDatos = "francisGol";

                self::$conexion = new mysqli($server, $usuario, $contrasenia, $baseDatos); // Inicio la conexión usando el objeto mysql

                if (self::$conexion->connect_errno) { // Si hay un error lo muestra

                    die("Error " . self::$conexion->connect_errno . " conectando a la base de datos: " . self::$conexion->connect_error);
                }

            }

            return self::$conexion; // Si todo va bien devuelve la conexión a la base de datos
        }
    }
